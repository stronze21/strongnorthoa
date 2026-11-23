<?php

namespace App\Http\Livewire\Shows;

use App\Mail\CookingShowDone;
use App\Models\CookingShow;
use App\Models\OrderAgreement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ViewShow extends Component
{

    use LivewireAlert;

    public $open_modal = false;
    public $cs_id, $show, $result, $amount_sold = 0, $date, $time;

    public function render()
    {

        return view('livewire.shows.view-show');
    }

    public function mount($cs_id)
    {
        $this->show = CookingShow::find($cs_id);
        $this->cs_id = $cs_id;
        $this->amount_sold = $this->show->amount_sold;
        $this->result = $this->show->result;
        $this->date = $this->show->date;
        $this->time = $this->show->time;
    }

    public function create_oa()
    {
        $oa_date = date('Y-m-d');
        $oa_client = $this->show->host_fullname();
        $oa_address = $this->show->address;
        $oa_contact = $this->show->contact_no;
        $oa_consultant = $this->show->lifechanger;
        $oa_associate = $this->show->partner;
        $oa_presenter = $this->show->presenter;
        $oa_team_builder = $this->show->team_builder;
        $oa_distributor = $this->show->distributor;

        $oa = OrderAgreement::create([
            'date' => $oa_date,
            'client' => $oa_client,
            'address' => $oa_address,
            'contact' => $oa_contact,
            'consultant' => $oa_consultant,
            'associate' => $oa_associate,
            'presenter' => $oa_presenter,
            'team_builder' => $oa_team_builder,
            'distributor' => $oa_distributor,
            'user_id' => Auth::user()->user_id,
            'cs_id' => $this->cs_id,
            'status' => 'Pending',
        ]);

        $this->redirect(route('oa.view', ['oa_id' => $oa->id]));
    }

    public function view_oa($oa_id)
    {
        $this->redirect(route('oa.view', ['oa_id' => $oa_id]));
    }

    public function openStatusModal()
    {
        $this->resetValidation();
        $this->result = $this->show->result;
        $this->amount_sold = $this->show->amount_sold ?: 0;
        $this->date = $this->show->date ? $this->show->date->format('Y-m-d') : null;
        $this->time = $this->show->time ? $this->show->time->format('H:i') : null;
        $this->open_modal = true;
    }

    public function closeStatusModal()
    {
        $this->open_modal = false;
        $this->resetValidation();
    }

    public function update_result()
    {
        $rules = ['result' => 'required|in:For Follow Up,Booked,Closed,Reschedule,Cancelled'];
        if ($this->result === 'Reschedule') {
            $rules['date'] = 'required|date_format:Y-m-d|after_or_equal:today';
            $rules['time'] = 'required|date_format:H:i';
        } elseif ($this->result === 'Closed') {
            $rules['amount_sold'] = 'nullable|numeric|min:0';
        }
        $this->validate($rules);

        $this->show->result = $this->result;
        if ($this->result === 'Reschedule') {
            $this->show->orig_date = $this->show->date;
            $this->show->orig_time = $this->show->time;
            $this->show->date = $this->date;
            $this->show->time = $this->time;
        } elseif ($this->result === 'Closed') {
            $this->show->amount_sold = $this->amount_sold ?: 0;
        }
        $this->show->save();
        $this->open_modal = false;

        if ($this->show->result == 'Closed') {
            $this->create_oa();
        }

        if ($this->show->result == 'Closed' or $this->show->result == 'For Follow Up') {
            Mail::to($this->show->host_email)->send(new CookingShowDone());
        }

        $this->alert('success', 'Result updated!');
    }
}
