import Tab from './components/Tab';
import Tabs from './components/Tabs';
import Api from "./js/Api";

export default {
    install(Vue) {
        let methods = Api(Vue);
        Vue.$tabs = methods;
        Vue.prototype.$tabs = methods;
        Vue.component('tab', Tab);
        Vue.component('tabs', Tabs);

    },
};

export { Tab, Tabs };
