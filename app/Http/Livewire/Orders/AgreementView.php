<?php

namespace App\Http\Livewire\Orders;

use App\Models\Product;
use Livewire\Component;
use App\Models\OrderAgreement;
use App\Models\OrderAgreementGift;
use App\Models\OrderAgreementItem;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AgreementView extends Component
{
    use LivewireAlert;
    protected $listeners = ['return_item', 'return_gift', 'delete_item', 'submit_order', 'cancel_order'];

    public $oa;
    public $item_id, $item_qty = 1, $item_remarks;
    public $gift_id, $gift_qty = 1, $gift_type;
    public $initial_investment, $delivery_date, $delivery_time, $current_level, $terms;

    public function render()
    {
        $products = Product::all();
        return view('livewire.orders.agreement-view', [
            'products' => $products,
        ]);
    }

    public function mount($oa_id)
    {
        $this->oa = OrderAgreement::find($oa_id);
    }

    public function add_item()
    {
        $this->validate([
            'item_id' => 'required|numeric',
            'item_qty' => 'required|min:1',
            'item_remarks' => 'nullable',
        ]);

        $product = Product::find($this->item_id);


        if ($product->tblset_id) {
            OrderAgreementItem::create([
                'order_agreement_id' => $this->oa->id,
                'product_id' => $this->item_id,
                'item_price' => $product->product_price,
                'item_qty' => $this->item_qty,
                'item_total' => $this->item_qty * $product->product_price,
                'remarks' => 'Composed of:',
            ]);

            foreach ($product->set->compositions()->get() as $row) {
                OrderAgreementItem::create([
                    'order_agreement_id' => $this->oa->id,
                    'product_id' => $row->product_id,
                    'item_price' => '0',
                    'item_qty' => $this->item_qty,
                    'item_total' => '0',
                    'remarks' => $product->set->set_name,
                    'tblset_id' => $row->tblsets_id,
                ]);
            }
        } else {
            OrderAgreementItem::create([
                'order_agreement_id' => $this->oa->id,
                'product_id' => $this->item_id,
                'item_price' => $product->product_price,
                'item_qty' => $this->item_qty,
                'item_total' => $this->item_qty * $product->product_price,
                'remarks' => $this->item_remarks,
            ]);
        }

        $this->resetExcept('oa');
        $this->alert('success', $this->item_qty . ' ' . $product->product_description . ' added to order as item.');
    }

    public function add_gift()
    {
        $this->validate([
            'gift_id' => 'required|numeric',
            'gift_qty' => 'required|min:1',
            'gift_type' => 'nullable',
        ]);

        $product = Product::find($this->gift_id);

        OrderAgreementGift::create([
            'order_agreement_id' => $this->oa->id,
            'product_id' => $this->gift_id,
            'item_price' => $product->product_price,
            'item_qty' => $this->gift_qty,
            'item_total' => $this->gift_qty * $product->product_price,
            'type' => $this->gift_type,
        ]);

        $this->resetExcept('oa');
        $this->alert('success', $this->item_qty . ' ' . $product->product_description . ' added to order as gift.');
    }

    public function delete_item($item_id, $type)
    {
        switch ($type) {
            case "item":
                $delete = OrderAgreementItem::find($item_id);
                break;

            case "gift":
                $delete = OrderAgreementGift::find($item_id);
                break;
        }
        $delete->delete();
        $this->alert('success', $type . ' removed successfully!');
    }

    public function update_details()
    {
        $this->oa->current_level = $this->current_level;
        $this->oa->delivery_date = $this->delivery_date;
        $this->oa->delivery_time = $this->delivery_time;
        $this->oa->initial_investment = $this->initial_investment;
        $this->oa->terms = $this->terms;
        $this->oa->save();

        $this->resetExcept('oa');
        $this->alert('success', 'Updated added details.');
    }

    public function upload_sig()
    {
        $folderPath = public_path('upload/');

        $image_parts = explode(";base64,", $this->signed);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);

        return $this->alert('success', 'success Full upload signature');
    }

    public function submit_order()
    {
        $this->oa->status = 'Waiting Confirmation';
        $this->oa->submitted = true;
        $this->oa->save();

        $this->alert('success', 'Congratulation! Your order has been sent to Saladmaster. Happy healthy cooking!', [
            'toast' => false,
            'position' => 'center',
            'timer' => false,
        ]);
    }

    public function cancel_order()
    {
        $this->oa->status = 'Cancelled';
        $this->oa->save();

        $this->resetExcept('oa');
        $this->alert('success', 'Order Cancelled.');
    }
}
