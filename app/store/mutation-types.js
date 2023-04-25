export const cartSymbol = Symbol.for('shop-cart').toString();

const mutationTypes = {
	SET_COMMON_OPTION: 'SET_COMMON_OPTION',
	SET_POLYLANG_COMMON: 'SET_POLYLANG_COMMON',
	SET_SITE_METADATA: 'SET_SITE_METADATA',
	SET_DELIVERY_AMOUNT: 'SET_DELIVERY_AMOUNT',
};

const shopMutations = {
	SET_DELIVERY_AMOUNT: 'SET_DELIVERY_AMOUNT',
	FILL_SHOP_CART: 'FILL_SHOP_CART',
	DELETE_SHOP_CART: 'DELETE_SHOP_CART',
	UPDATE_CART_EXPIRATION: 'UPDATE_CART_EXPIRATION',

	ADD_PRODUCT: 'ADD_PRODUCT',
	DELETE_PRODUCT: 'DELETE_PRODUCT',
	UPDATE_PRODUCT: 'UPDATE_PRODUCT',

	ADD_SERVICE: 'ADD_SERVICE',
	DELETE_SERVICE: 'DELETE_SERVICE',
	UPDATE_SERVICE: 'UPDATE_SERVICE',
	UPDATE_SERVICE_PAID: 'UPDATE_SERVICE_PAID',
};

const payerMutations = {
	UPDATE_SHOPPER: 'UPDATE_SHOPPER',
	DELETE_SHOPPER: 'DELETE_SHOPPER',
	VALIDATE_FORM: 'VALIDATE_FORM',
	SET_PAYED_SHOPPER: 'SET_PAYED_SHOPPER',
};

const bookingMutations = {
	SET_DATE_BOOKING: 'SET_DATE_BOOKING',
	UPDATE_DATE_BOOKING: 'UPDATE_DATE_BOOKING',
	DELETE_DATE_BOOKING: 'DELETE_DATE_BOOKING',
	SET_AVAILABLE_USERS: 'SET_AVAILABLE_USERS',
	SET_BOOKING_SCHEDULE: 'SET_BOOKING_SCHEDULE',
	BOOKING_FETCH_STATUS: 'BOOKING_FETCH_STATUS',
	BOOKING_FETCH_SUCCESS: 'BOOKING_FETCH_SUCCESS',
};

const eventMutations = {
	ERROR_EVENT: 'ERROR_EVENT',
	SUCCESS_EVENT: 'SUCCESS_EVENT',
	WARNING_EVENT: 'WARNING_EVENT',
	GENERIC_EVENT: 'GENERIC_EVENT',
	REMOVE_EVENT: 'REMOVE_EVENT',
};

export default Object.freeze({
	...mutationTypes,
	...shopMutations,
	...payerMutations,
	...bookingMutations,
	...eventMutations,
});