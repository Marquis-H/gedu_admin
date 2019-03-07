import Vue from 'vue';
import { i18n } from './common';

import App from './App'
import router from './router'
import store from './store'
import Raven from 'raven-js';
import RavenVue from 'raven-js/plugins/vue';

const isProduction = process.env.NODE_ENV === 'production';

/* Configure whether to allow vue-devtools inspection. */
//Vue.config.devtools = !isProduction;

/* Set this to false to prevent the production tip on Vue startup(2.2.0+). */
Vue.config.productionTip = !isProduction;

/* Suppress all Vue logs and warnings. */
Vue.config.silent = isProduction;

new Vue({
    router,
    store,
    i18n,
    render: h => h(App),
    performance: !isProduction,
    data: {
        sub: false,
    },
}).$mount('#app');

if (isProduction) {
    Raven.config('https://6310b6f6e0514708a2f2220e0ce4690b@sentry.io/1254558')
        .addPlugin(RavenVue, Vue)
        .install();
}