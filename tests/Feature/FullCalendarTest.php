<?php

namespace Tests\Feature;

use App\Http\Livewire\Shows\FullCalendar;
use App\Models\CookingShow;
use Carbon\Carbon;
use Tests\TestCase;

class FullCalendarTest extends TestCase
{
    public function test_calendar_filters_are_applied_to_the_booking_query()
    {
        $user = \Mockery::mock(\App\Models\User::class)->makePartial();
        $user->user_id = 7;
        $user->shouldReceive('hasRole')->with('admin')->andReturn(false);
        $this->actingAs($user);
        $calendar = new FullCalendar;
        $calendar->month = '2026-11';
        $calendar->lifechanger = 'Sample Consultant';
        $calendar->resultFilter = 'follow_up';
        $calendar->fromDate = '2026-11-10';
        $calendar->toDate = '2026-11-20';
        $queries = \Illuminate\Support\Facades\DB::connection('mysql')->pretend(function () use ($calendar) {
            $calendar->render();
        });
        $query = collect($queries)->last();
        foreach ([7, 'Sample Consultant', 'for follow up', 'follow up', '2026-11-10', '2026-11-20'] as $value) {
            $this->assertContains($value, $query['bindings']);
        }
        $calendar->resetFilters();
        $this->assertSame('', $calendar->lifechanger);
        $this->assertSame('', $calendar->resultFilter);
        $this->assertSame('', $calendar->fromDate);
        $this->assertSame('', $calendar->toDate);
    }

    public function test_livewire_renders_month_and_navigates_without_property_collision()
    {
        $user = \Mockery::mock(\App\Models\User::class)->makePartial();
        $user->user_id = 1;
        $user->shouldReceive('hasRole')->with('admin')->andReturn(true);
        $this->actingAs($user);

        // Execute the real Eloquent query and Livewire rendering without a database write.
        \Illuminate\Support\Facades\DB::connection('mysql')->pretend(function () {
            \Livewire\Livewire::test(FullCalendar::class, ['month' => '2026-11'])
                ->assertSee('November')
                ->assertSee('No cooking show bookings for November 2026.')
                ->call('nextMonth')
                ->assertSet('month', '2026-12')
                ->assertSee('December')
                ->call('previousMonth')
                ->assertSee('November');
        });
    }

    public function test_month_navigation_crosses_year_boundaries()
    {
        $calendar = new FullCalendar;
        $calendar->month = '2026-12';
        $calendar->nextMonth();
        $this->assertSame('2027-01', $calendar->month);
        $calendar->previousMonth();
        $this->assertSame('2026-12', $calendar->month);
    }

    public function test_invalid_month_defaults_to_current_month()
    {
        $calendar = new FullCalendar;
        $calendar->month = '2026-99';
        $calendar->mount();
        $this->assertSame(now()->format('Y-m'), $calendar->month);
    }

    public function test_calendar_colors_follow_up_and_amounts_and_escapes_names()
    {
        $shows = collect([
            new CookingShow(['host' => '<script>alert(1)</script>', 'result' => 'Follow Up', 'date' => '2026-11-16']),
            new CookingShow(['host' => 'Amount host', 'result' => 'Closed', 'date' => '2026-11-16']),
        ]);
        $shows[0]->cs_id = 1;
        $shows[1]->cs_id = 2;
        $shows[1]->amount_sold = 15000;
        $html = view('livewire.shows.full-calendar', [
            'calendarMonth' => Carbon::parse('2026-11-01'),
            'days' => [Carbon::parse('2026-11-16')],
            'shows' => collect(['2026-11-16' => $shows]),
        ])->render();
        $this->assertStringContainsString('calendar-event calendar-follow-up', $html);
        $this->assertStringContainsString('calendar-event calendar-amount', $html);
        $this->assertStringContainsString('15,000.00', $html);
        $this->assertStringNotContainsString('<script>alert(1)</script>', $html);
    }
}

