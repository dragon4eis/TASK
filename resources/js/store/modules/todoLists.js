import axios from 'axios';
import errors from "../reusable/errors";
import resources from "../reusable/resources";

export default {
    namespaced: true,
    modules: {
        errors,
        resources: resources('/todoList')
    },
    state:{
    },
    mutations:{

    },
    getters:{

    },
    actions:{

    }
}
