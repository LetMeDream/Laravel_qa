/** Custom authorization plugin */


import policies from './policies'; /** Importing created custom policies */
/** Now i want to create a function that could be called in a template like this->
 *  authorize('modify',answer); We will modify vue.protoype, in order to do that. */

export default {

    install(Vue,options){
        Vue.prototype.authorize = function (policy, model){
            /** Making sure is user has signed in */
            if (window.Auth.signedIn===false) return false;
            if (typeof policy === 'string' && typeof model === 'object'){
                /** Holding our user in a variable */
                const user = window.Auth.user;
                return policies[policy](user, model);
                // So, in the end, calling something like this: authorize['modify',answer]
                //                                 will return= policies.modify(user, answer)
            }
        }

        /** Making signedIn variable accesible from our Javascript code */
        Vue.prototype.signedIn = window.Auth.signedIn;
    }

}

