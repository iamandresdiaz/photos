import { EventEmitter } from "events";
import dispatcher from "../../AppDispatcher";
import { searchConstants } from "../../../Shared/constants/SearchConstants";

class SearchStore extends EventEmitter{
    constructor(){
        super();
        this.response = {};
    }

    getResponse() {
        return this.response;
    }

    handleActions(action){
        switch (action.type) {
            case searchConstants.SEARCH_RESPONSE:

                if(action.error){
                    this.response = {
                        'data': null,
                        'error': {
                            'type': searchConstants.SEARCH_ERROR
                        }
                    };

                    this.emit(searchConstants.SEARCH_ERROR);
                } else {
                    this.response = {
                        'data': action.data,
                        'error': null
                    };

                    this.emit(searchConstants.SEARCH_SUCCESS);
                }
                break;

            default:
                break;
        }
    }
}

let searchStore = new SearchStore();
dispatcher.register(searchStore.handleActions.bind(searchStore));

export default searchStore;