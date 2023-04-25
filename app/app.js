const PORT = process.env.PORT || 3031;
const { loadNuxt } = require('nuxt');

async function init() {
	const nuxt = await loadNuxt({ for: 'start' });
	const data =await nuxt.listen(PORT);
	console.log('[Server Runing]', new Date().toISOString());
	console.log('[Server Runing]', `${data.url}` );
}

init().catch(error => {
	console.log('Server Error', error, new Date().toISOString());
});
