<?php

namespace Lotus\Modules\Order;

// use Lotus\Modules\Bookly\Schedule\ScheduleRepository;

use Lotus\Modules\Bookly\Schedule\ScheduleRepository;
use Lotus\Modules\Product\ProductRepository;
use WP_REST_Request as Request;
use WP_REST_Response as Response;

class OrderController
{
	/**
	 * Data manager instance
	 * @var \Lotus\Modules\Order\OrderRepository
	 */
	private $orderRepository;

	/**
	 * Data manager instance
	 * @var \Lotus\Modules\Bookly\Schedule\ScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * Data manager instance
	 * @var \Lotus\Modules\Product\ProductRepository
	 */
	private $productRepository;

	public function __construct(OrderRepository $orderRepository, ScheduleRepository $scheduleRepository, ProductRepository $productRepository)
	{
		$this->orderRepository = $orderRepository;
		$this->scheduleRepository = $scheduleRepository;
		$this->productRepository = $productRepository;
	}

	/** ================================================================= \
	 * Function purchase order creator and managing Mailer
	 *  @link api/shop/order/?params \
	 *  =================================================================*/

	public function create_order(Request $request)
	{
		$params   = (object) $request->get_params();
		$user     = (object) $params->user;
		$products = (array) $params->products;
		$services = (array) $params->services;
		try {
			$response = [];
			if (count($services)) {
				foreach ($services as $service) {
					$date = (object) ['from' => $service['from'], 'to' => $service['to']];
					$customer = (object)[
						'name'    => "$user->name $user->last_name",
						'phone'   => $user->phone,
						'email'   => $user->email,
						'note'    => $user->note ?? '',
						'paid'    => $service['paid'],
						'address' => "$user->address_1 $user->address_2"
					];
					$this->scheduleRepository->create($date, (int) $service['doctor'], (int) $service['id'], $customer);
				}
			}
			// if (count($products)) {
				$response = $this->orderRepository->create_order($user, $products, $services);
			// }
			return new Response($response, 200);
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"code"    => $th->getCode()
			], 500);
		}
	}
	/** ================================================================= \
	 * Function purchase order creator and managing Mailer
	 *  @link api/shop/order/?params \
	 *  =================================================================*/

	public function verify_order(Request $request)
	{
		$params   = (object) $request->get_params();
		$products = $params->products;
		$services = $params->services;
		try {
			$response = $this->productRepository->verifyProductStockList($products);
			return new Response($response, 200);
		} catch (\Exception $th) {
			return new Response([
				"status"  => "Internal Server Error",
				"message" => $th->getMessage()
			], 500);
		}
	}
}
