<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\V1\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return OrderResource::collection(Order::where('user_id', $request->user()->id)->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderRequest $request
     * @return OrderResource
     */
    public function store(StoreOrderRequest $request)
    {
        $requestData = $request->all();
        $requestData['user_id'] = $request->user()->id;
        /** @var Order $order */
        $order = Order::create($requestData);

        foreach ($request->products as $product) {
            $order->products()->attach(
                $product['id'],
                ['count' => $product['count']]
            );
        }

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return OrderResource
     */
    public function show(Request $request, Order $order)
    {
        if ($request->user()->id === $order->user_id) {
            return new OrderResource($order);
        }

        return abort('403', 'Unauthorized.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return OrderResource
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        if ($request->user()->id === $order->user_id) {
            $order->update($request->all());
            if (is_array($request->products)) {
                $order->products()->detach();
                foreach ($request->products as $product) {
                    $order->products()->attach(
                        $product['id'],
                        ['count' => $product['count']]
                    );
                }
            }

            return new OrderResource($order);
        }

        return abort('403', 'Unauthorized.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return Response
     */
    public function destroy(Request $request, Order $order)
    {
        if ($request->user()->id === $order->user_id) {
            $order->delete();

            return Response('OK', 200);
        }

        return abort('403', 'Unauthorized.');
    }
}
