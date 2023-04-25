import { httpClient } from '~/plugins/http';

/**
 * @typedef { import('./x-models').Product } Product
 * @typedef { import('./x-models').Service } Service
 * @typedef { import('./x-models').User } User
 */

export class ShopService {
	/**
	 * Verify and return true product is available in stock
	 *
	 * @param { number } id - Id of product
	 * @param { number } quantity
	 *
	 * @returns { Promise<boolean> }
	 */
	async verifyProduct(id, quantity) {
		try {
			const { data: response, status } = await httpClient.post(`/shop/product/verify/${id}`, {
				qty: quantity,
			});
			if (response.status === true && status === 200) {
				return true;
			}
			return response.data;
		} catch (error) {
			Promise.reject(error);
		}
	}

	/**
	 * Verify all products and return true products is available in stock
	 *
	 * @param { Product[] } products
	 * @param { Service[] } services
	 *
	 * @returns { Promise<boolean> }
	 */
	async verifyAllProducts(products, services) {
		try {
			const { data: verify } = await httpClient.post(`/order/verify`, { products, services });
			if (verify.status == true) {
				return true;
			}
			return verify.data;
		} catch (error) {
			throw error;
		}
	}

	/**
	 * Create order and save user in database
	 *
	 * @param { User } user
	 * @param { Product[] } products
	 * @param { Service[] } services
	 *
	 * @returns
	 */

	async createOrder(user, products, services) {
		try {
			const factoryOrder = {
				user: user,
				products: products,
				services: services,
			};
			const { data: created } = await httpClient.post(`/order/create`, factoryOrder);
			// console.log(created)
			if (created.status == 'success') {
				return created;
			}
			return false;
		} catch (error) {
			console.log(error);
			throw error;
		}
	}
}

export const shopService = new ShopService();
