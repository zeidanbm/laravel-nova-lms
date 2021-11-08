import Vue from 'vue'
import VueCompositionAPI from '@vue/composition-api'
Vue.use(VueCompositionAPI)

import router from '@/plugins/router-setup'
import store from './store'
import App from './App.vue'

import { i18n } from '@/plugins/i18n-setup'
import { library } from '@fortawesome/fontawesome-svg-core'
import {
	faSearch,
	faBookOpen,
	faBook,
	faUsers,
	faQuoteLeft,
	faPlus,
	faEnvelope,
	faPhone,
	faLocationArrow,
	faAngleRight,
	faAngleLeft,
	faCircleNotch,
	faFilter
} from '@fortawesome/free-solid-svg-icons'
import { faFacebookF, faTwitter, faInstagram } from '@fortawesome/free-brands-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import '../css/app.scss'

library.add(
	faSearch,
	faBookOpen,
	faBook,
	faUsers,
	faQuoteLeft,
	faPlus,
	faEnvelope,
	faPhone,
	faLocationArrow,
	faFacebookF,
	faInstagram,
	faTwitter,
	faEnvelope,
	faAngleRight,
	faAngleLeft,
	faCircleNotch,
	faFilter
)

Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.config.productionTip = false

new Vue({
	render: (h) => h(App),
	i18n,
	store,
	router,
	components: { App }
}).$mount('#app')
