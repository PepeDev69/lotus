import { httpClient } from "@/plugins/http";

export default function ({ app, store }) {
	app.i18n.onLanguageSwitched = async (oldLang, lang) => {
		const { data: common } = await httpClient.get(`/common?lang=${lang}`);
		store.dispatch("updateCommonOptions", common);
	};
}
