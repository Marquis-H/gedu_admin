import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters'
import app from './modules/app'
import tagsView from './modules/tagsView'
import user from './modules/user'
import errorLog from './modules/errorLog'
import permission from './modules/permission'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        app,
        tagsView,
        user,
        errorLog,
        permission
    },
    getters
})

export default store