import Vue from 'vue';
import VueI18n from 'vue-i18n';
import locales from 'locales';

import 'normalize.css/normalize.css';

import Element from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import '@/styles/index.scss' // global css

Vue.use(VueI18n);
Vue.use(Element);

const defaultLanguage = 'cn';

import './icons'
import './errorLog'
import './permission'
import './mock'

import * as filters from './filters'
// register global utility filters.
Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key])
})

export const i18n = new VueI18n({
    locale: defaultLanguage,
    fallbackLocale: defaultLanguage,
    messages: locales,
    silentTranslationWarn: true
});