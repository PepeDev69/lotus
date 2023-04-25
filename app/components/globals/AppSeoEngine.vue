<template>
    <span v-if="false"></span>
</template>
<script>
export default {
    name: 'SeoEngine',
    props: {
        seoMeta: {
            type: [Object, Array],
            default: () => ({})
        }
    },
    head () {
        if (Object.keys(this.seoMeta).length === 0) {
            return {}
        }
        return {
            title: this.seoMeta.og_title,
            link: [
                {
                    hid: 'url',
                    rel: 'canonical',
                    href: this.seoMeta.canonical || this.seoMeta.og_url
                }
            ],
            meta: [
                { name: 'robots', content: Object.values(this.seoMeta.robots) },
                {
                    hid: 'description',
                    name: 'description',
                    content: this.seoMeta.description
                },
                {
                    name: 'keywords',
                    content: ''
                },

                //---->>> Twitter Support <<<------>
                {
                    name: 'twitter:title',
                    hid: 'tw-title',
                    content: this.seoMeta.og_title
                },
                {
                    name: 'twitter:url',
                    hid: 'tw-url',
                    content: this.seoMeta.canonical || this.seoMeta.og_url
                },
                {
                    name: 'twitter:image',
                    hid: 'tw-image',
                    content: this.seoMeta.canonical
                },
                {
                    name: 'twitter:description',
                    hid: 'tw-description',
                    content: this.seoMeta.description
                },
                { name: 'twitter:creator', hid: 'tw-creator', content: '' },
                { name: 'twitter:card', content: this.seoMeta.twitter_card },

                //---->>> Open Graph <<<------>
                {
                    property: 'og:title',
                    hid: 'og-title',
                    content: this.seoMeta.og_title
                },
                { property: 'og:url', hid: 'og-url', content: '' },
                {
                    property: 'og:image',
                    hid: 'og-image',
                    content: this.seoMeta.canonical || this.seoMeta.og_url
                },
                {
                    property: 'og:description',
                    hid: 'og-description',
                    content: this.seoMeta.og_description
                },
                { property: 'og:site_name', hid: 'og-site', content: '' },
                {
                    property: 'website:publish_time',
                    hid: 'og-publish',
                    content: this.seoMeta.article_modified_time
                },
                { property: 'og:type', content: 'Website' }
            ],
            __dangerouslyDisableSanitizers: ['script'],
            script: [
                {
                    innerHTML: JSON.stringify(this.seoMeta.schema),
                    type: 'application/ld+json'
                }
            ]
        }
    }
}
</script>
