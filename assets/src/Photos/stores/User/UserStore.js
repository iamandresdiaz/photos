import { EventEmitter } from "events";
import dispatcher from "../../AppDispatcher";
import { userConstants } from "../../../Shared/constants/User/UserConstants";

class UserStore extends EventEmitter{
    constructor(){
        super();
        this.apiResponse = {};
    }

    getResponse() {
        return this.apiResponse;
    }

    handleActions(action){
        switch (action.type) {
            case userConstants.LOGIN_RESPONSE:

                if(action.error){
                    console.log({
                        type: userConstants.LOGIN_ERROR,
                        message: action.error
                    });
                }

                this.apiResponse = action.response;

                this.emit(userConstants.LOGIN_SUCCESS);
                break;

            case userConstants.REGISTER_RESPONSE:

                if(action.error){
                    console.log({
                        type: userConstants.REGISTER_ERROR,
                        message: action.error
                    });
                }

                this.apiResponse = action.response;

                this.emit(userConstants.REGISTER_SUCCESS);
                break;

            default:
                break;
        }
    }
}

let userStore = new UserStore();
dispatcher.register(userStore.handleActions.bind(userStore));

export default userStore;