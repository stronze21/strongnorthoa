<?php

namespace App\Http\Livewire\Orders;

use App\Models\CookingShow;
use App\Models\OrderAgreement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AgreementList extends Component
{
    use WithPagination;

    public $search;
    public $cs_id, $oa_number, $oa_count, $oa_date, $oa_client, $oa_address, $oa_contact, $oa_consultant, $oa_associate, $oa_presenter, $oa_team_builder, $oa_distributor;

    public function updatedCsId()
    {
        $cs = CookingShow::find($this->cs_id);
        if($cs){
            $this->oa_date = $cs->date;
            $this->oa_client = $cs->host_fullname();
            $this->oa_address = $cs->address;
            $this->oa_contact = $cs->contact_no;
            $this->oa_consultant = $cs->lifechanger;
            $this->oa_associate = $cs->partner;
            $this->oa_presenter = $cs->presenter;
            $this->oa_team_builder = $cs->team_builder;
            $this->oa_distributor = $cs->distributor;
        }else{
            $this->resetExcept('cs_id');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $orders = OrderAgreement::where('user_id', Auth::user()->user_id)->paginate(20);
        $bookings = CookingShow::where('host', 'LIKE', '%'.$this->oa_client.'%')
                                ->where('user_id', Auth::user()->user_id)
                                ->where('result', '<>', 'Booked')
                                ->orderBy('date', 'DESC');


        return view('livewire.orders.agreement-list', [
            'orders' => $orders,
            'bookings' => $bookings->get(),
        ]);
    }

    public function mount()
    {
        $bookings = CookingShow::where('host', 'LIKE', '%'.$this->oa_client.'%')
                                ->where('user_id', Auth::user()->user_id)
                                ->where('result', '<>', 'Booked')
                                ->orderBy('date', 'DESC')
                                ->first();


        if($bookings){
            $this->cs_id = $bookings->cs_id;
        }
        $this->updatedCsId();
    }

    public function save()
    {
        $this->validate([
            'cs_id' => ['required'],
            'oa_date' => ['required', 'date_format:Y-m-d'],
            'oa_client' => ['required', 'string'],
            'oa_address' => ['required', 'string'],
            'oa_contact' => ['required', 'string'],
            'oa_consultant' => ['nullable'],
            'oa_associate' => ['nullable'],
            'oa_presenter' => ['nullable'],
            'oa_team_builder' => ['nullable'],
            'oa_distributor' => ['nullable'],
        ]);

        $oa = OrderAgreement::create([
            'date' => $this->oa_date,
            'client' => $this->oa_client,
            'address' => $this->oa_address,
            'contact' => $this->oa_contact,
            'consultant' => $this->oa_consultant,
            'associate' => $this->oa_associate,
            'presenter' => $this->oa_presenter,
            'team_builder' => $this->oa_team_builder,
            'distributor' => $this->oa_distributor,
            'user_id' => Auth::user()->user_id,
            'cs_id' => $this->cs_id,
            'status' => 'Pending',
        ]);

        $show = CookingShow::find($this->cs_id);
        if($show){
            $show->result = 'Closed';
            $show->save();
        }

        $this->redirect(route('oa.view', ['oa_id' => $oa->id]));

    }

    public function view_oa($oa_id)
    {
        $this->redirect(route('oa.view', ['oa_id' => $oa_id]));
    }
}
