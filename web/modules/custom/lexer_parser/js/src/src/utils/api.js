export default class Api {

    static getAppContainerId() {
        return 'react-app-container'
    }

    static getDataAttributeValue(attribute) {
        // @todo exception handling
        return document.getElementById(Api.getAppContainerId()).getAttribute(`data-${attribute}`)
    }

}
