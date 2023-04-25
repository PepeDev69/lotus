export class SessionStorageManager {
	constructor(time = 0.5) {
		this.current = Date.now();
		this.minute = 60000;
		this.hour = this.formatMinutes(60);
	}

	/**
	 * @param { string } key
	 * @param { string } deepKey
	 * @returns { Record<string|Array>|Array|null }
	 */
	getItem(key, deepKey = null) {
		const storage = localStorage.getItem(key);
		if (Boolean(storage) === false) {
			return null;
		}
		const data = JSON.parse(storage);
		const now = new Date();
		if (now.getTime() > data.expiry) {
			localStorage.removeItem(key);
			return null;
		}

		return Boolean(deepKey) ? data.value[deepKey] : data.value;
	}

	/**
	 * @param { string } key
	 * @param { any } value
	 * @param { number } ttl
	 *
	 * @returns { void }
	 */
	setItem(key, value, ttl = 24) {
		const now = new Date();
		const factoryStore = {
			value: value,
			expiry: now.getTime() + this.formatHours(ttl),
		};
		localStorage.setItem(key, JSON.stringify(factoryStore));
	}

	/**
	 * @param { number } minutes
	 * @returns { number }
	 */
	formatMinutes(minutes = 1) {
		return minutes * this.minute;
	}

	/**
	 * @param { number } hours
	 * @returns { number }
	 */
	formatHours(hours = 24) {
		return hours * this.hour;
	}

	updateExpirationTime(key, time) {
		const store = localStorage.getItem(key);
		if (store) {
			const state = store.value;
			this.setItem(key, state);
		}
	}
}

export const sessionStorageManager = new SessionStorageManager();
