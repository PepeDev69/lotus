export default function ({ store, redirect, app }) {
	const isEmpty = store.getters["shop/isCartEmpty"];
	// if (!isEmpty) {
	// 	return redirect(app.localePath({ name: "shop-cart" }));
	// }
	return true;
}
