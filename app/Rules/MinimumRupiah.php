<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinimumRupiah implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($min)
    {
        //
        $this->min = $min;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        return  str_replace('.', '', $value) >= $this->min;
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Inquiry Deposit Minimal '.$this->min;
    }
}
