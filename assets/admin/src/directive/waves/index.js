import waves from './waves'

const install = function (vue) {
    Vue.directive('waves', waves)
}

if (window.Vue) {
    window.waves = waves
    Vue.use(install); // eslint-disable-line
}

waves.install = install
export default waves