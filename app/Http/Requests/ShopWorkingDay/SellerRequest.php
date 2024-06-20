<?php
declare(strict_types=1);

namespace App\Http\Requests\ShopWorkingDay;

use App\Http\Requests\BaseRequest;

class SellerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return (new AdminRequest)->rules();
    }
}
