<?php
declare(strict_types=1);

namespace App\Http\Controllers\API\v1\Dashboard\Master;

use App\Helpers\ResponseError;
use App\Http\Requests\FilterParamsRequest;
use App\Http\Resources\PaymentToPartnerResource;
use App\Models\PaymentToPartner;
use App\Repositories\PaymentToPartnerRepository\PaymentToPartnerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentToPartnerController extends MasterBaseController
{

    public function __construct(private PaymentToPartnerRepository $repository)
    {
        parent::__construct();
    }

    public function index(FilterParamsRequest $request): AnonymousResourceCollection
    {
		$filter = $request->merge([
			'user_id' 	=> auth('sanctum')->id(),
			'type' 		=> PaymentToPartner::DELIVERYMAN
		])->all();

        $models = $this->repository->paginate($filter);

        return PaymentToPartnerResource::collection($models);
    }

    public function show(int $id): JsonResponse
    {
        $model = $this->repository->show($id);

        if (empty($model) || $model->user_id !== auth('sanctum')->id()) {
            return $this->onErrorResponse([
                'code'      => ResponseError::ERROR_404,
                'message'   => __('errors.' . ResponseError::ERROR_404, locale: $this->language)
            ]);
        }

        return $this->successResponse(
			__('errors.' . ResponseError::NO_ERROR, locale: $this->language),
			PaymentToPartnerResource::make($model)
		);
    }

}
