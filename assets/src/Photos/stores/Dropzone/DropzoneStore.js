import { EventEmitter } from "events";
import dispatcher from "../../AppDispatcher";
import { dropzoneConstants } from "../../../Shared/constants/DropzoneConstants";

class DropzoneStore extends EventEmitter{
    constructor(){
        super();
        this.apiResponse = {};
    }

    getResponse() {
        return this.apiResponse;
    }

    handleActions(action){
        switch (action.type) {
            case dropzoneConstants.UPLOAD_RESPONSE:

                if(action.error){
                    console.log({
                        type: dropzoneConstants.UPLOAD_ERROR,
                        message: action.error
                    });
                }

                this.apiResponse = action.response;

                this.emit(dropzoneConstants.UPLOAD_SUCCESS);
                break;

            default:
                break;
        }
    }
}

let dropzoneStore = new DropzoneStore();
dispatcher.register(dropzoneStore.handleActions.bind(dropzoneStore));

export default dropzoneStore;