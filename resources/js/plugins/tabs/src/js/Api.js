import {EventBus} from "./event-bus";

const Api = (Vue) => {
    return{
        selectTab(val) {
            EventBus.$emit('select-tab', val)
        }
    }
}

export default Api;