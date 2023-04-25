<?php

namespace Lotus\Modules\Order;

class OrderRepository
{

	/** ================================================================= \
	 * Function purchase order creator and managing Mailer
	 *  @link api/shop/order/?params \
	 *  =================================================================*/

	public function create_order(object $user, array $products, array $services)
	{
		$complete_address = [
			'first_name' => $user->name,
			'last_name'  => $user->last_name,
			'company'    => $user->company,
			'email'      => $user->email,
			'phone'      => $user->phone,
			'address_1'  => $user->address_1,
			'address_2'  => $user->address_2,
			'city'       => $user->city,
			'state'      => $user->state,
			'postcode'   => $user->postcode,
			'country'    => $user->country ?: 'US'
		];

		$order = wc_create_order();

		if ($products . length !== 0) {
			foreach ($products as $item) {
				$_product = wc_get_product($item['id']);
				if ($_product->get_stock_status() != 'instock' || $_product->get_stock_quantity() <= 0) {
					return ['message' => $_product->get_name() . ' Out Of Stock'];
				}
				$order->add_product($_product, $item['quantity']);
			}
		}
		if ($services . length !== 0) {
			foreach ($services as $item) {
				$_product = wc_get_product($item['id']);
				// if ($_product->get_stock_status() != 'instock' || $_product->get_stock_quantity() <= 0) {
				// 	return ['message' => $_product->get_name() . ' Out Of Stock'];
				// }
				$order->add_product($_product, $item['quantity']);
			}
		}


		$order->set_address($complete_address, 'billing');
		$order->set_address($complete_address, 'shipping');

		$order->calculate_totals();

		$shipping = new \WC_Order_Item_Shipping();
		if ($order->get_total() > intval(get_field('delivery_limit') ?? 300)) {
			$shipping->set_method_title("Delivery");
			$shipping->set_method_id("free_shipping:1");
		} else {
			$shipping->set_method_title("Flat Rate");
			$shipping->set_method_id("flat_rate:2");
			$shipping->set_total(intval(get_field('delivery_amount')) ?? 15);
		}


		// $prueba = get_field('delivery_limit', 'options');
		// $prueba2 = get_field('delivery_amount', 'options');

		// return $prueba;

		$order->add_item($shipping);
		$order->calculate_totals();
		$order->save();
		$order->update_status("completed");

		$mailer = new \WC_Email_New_Order();
		$mailer->trigger($order->get_id(), $order);

		$response = (object) [
			'status'  => 'success',
			'message' => 'Thank you. Your order has been received.',
			'order'   => $order->get_order_number(),
			'date'    => $order->get_date_created(),
			'email'   => $user->email
		];
		return $response;
	}
}