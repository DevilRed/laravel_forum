<?php
namespace App\Http\Livewire\Form;
use Livewire\Component;
use App\Models\Product;

class Wizard extends Component
{
    public $currentStep = 1;
    public $name, $price, $detail = "";
    public $successMsg = '';

    /**
     * Write code on Method
     */
    public function render()
    {
        return view('livewire.form.wizard');
    }

    /**
     * Write code on Method
     */
    public function firstStepSubmit()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $this->currentStep = 2;
    }

    /**
     * Write code on Method
     */
    public function secondStepSubmit()
    {
        $validatedData = $this->validate([
            'detail' => 'required',
        ]);

        $this->currentStep = 3;
    }

    /**
     * Write code on Method
     */
    public function submitForm()
    {
        Product::create([
            'name' => $this->name,
            'price' => $this->price,
            'detail' => $this->detail,
        ]);

        $this->successMsg = 'Product successfully created.';

        $this->clearForm();

        $this->currentStep = 1;
    }

    /**
     * Write code on Method
     */
    public function back($step)
    {
        $this->currentStep = $step;
    }

    /**
     * Write code on Method
     */
    public function clearForm()
    {
        $this->name = '';
        $this->price = '';
        $this->detail = '';
    }
}
