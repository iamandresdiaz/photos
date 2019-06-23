import { EventEmitter } from "events";
import dispatcher from "../../AppDispatcher";
import { dropzoneConstants } from "../../../Shared/constants/DropzoneConstants";

class DropzoneStore extends EventEmitter{
    constructor(){
        super();
        this.response = {};
    }

    getResponse() {
        return this.response;
    }

    handleActions(action){
        switch (action.type) {
            case dropzoneConstants.UPLOAD_RESPONSE:

                if(action.error){
                    this.response = {
                        'success': null,
                        'error': dropzoneConstants.UPLOAD_ERROR
                    };

                    this.emit(dropzoneConstants.UPLOAD_ERROR);
                } else {
                    this.response = {
                        'success': action.status,
                        'error': null
                    };

                    this.emit(dropzoneConstants.UPLOAD_SUCCESS);
                }
                break;

            default:
                break;
        }
    }
}

let dropzoneStore = new DropzoneStore();
dispatcher.register(dropzoneStore.handleActions.bind(dropzoneStore));

export default dropzoneStore;