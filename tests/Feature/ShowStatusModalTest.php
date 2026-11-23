<?php

namespace Tests\Feature;

use App\Http\Livewire\Shows\ViewShow;
use App\Models\CookingShow;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ShowStatusModalTest extends TestCase
{
    public function test_cancellation_ignores_hidden_amount_and_preserves_saved_sales()
    {
        \Illuminate\Support\Facades\Mail::fake();
        $show = new class extends CookingShow {
            public $saved = false;
            public function save(array $options = [])
            {
                $this->saved = true;
                return true;
            }
        };
        $show->amount_sold = 1500;
        $component = \Mockery::mock(ViewShow::class)->makePartial();
        $component->show = $show;
        foreach (['Cancelled', 'Booked', 'For Follow Up'] as $status) {
            $component->shouldReceive('alert')->once();
            $component->result = $status;
            $component->amount_sold = 'irrelevant hidden value';
            $component->update_result();
            $this->assertSame($status, $show->result);
            $this->assertTrue($show->saved);
            $this->assertEquals(1500, $show->amount_sold);
            $this->assertFalse($component->open_modal);
        }
    }

    public function test_opening_restores_saved_values_and_formats_schedule_for_inputs()
    {
        $component = new ViewShow;
        $component->show = new CookingShow(['date' => '2026-11-23', 'time' => '18:30:00', 'result' => 'Booked']);
        $component->result = 'Cancelled';
        $component->openStatusModal();
        $this->assertTrue($component->open_modal);
        $this->assertSame('Booked', $component->result);
        $this->assertSame('2026-11-23', $component->date);
        $this->assertSame('18:30', $component->time);
        $component->closeStatusModal();
        $this->assertFalse($component->open_modal);
    }

    public function test_negative_amount_is_rejected_before_saving()
    {
        $component = new ViewShow;
        $component->result = 'Closed';
        $component->amount_sold = -100;
        try {
            $component->update_result();
            $this->fail('Negative amount was accepted.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('amount_sold', $exception->errors());
        }
    }

    public function test_rescheduling_requires_a_future_date_and_valid_time()
    {
        $component = new ViewShow;
        $component->result = 'Reschedule';
        $component->date = '2020-01-01';
        $component->time = 'invalid';
        try {
            $component->update_result();
            $this->fail('Invalid schedule was accepted.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('date', $exception->errors());
            $this->assertArrayHasKey('time', $exception->errors());
        }
    }
}
