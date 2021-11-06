class Motoboys {
    
    constructor(){
        this.formEl = document.querySelector("#formMotoboy");

        this._idButtonOperationEl = "";

        this.onSubmit();
    }

    onSubmit(){
        this.formEl.addEventListener('submit', (event)=>{
            event.preventDefault();
        })
    }

    getValues() {
        let user = {};
        [...this.formEl.elements].forEach(function(field, index){
            user[field.name] = field.value;
        })  
        return user;
    }


    get idMotoboy(){
        return this.id;
    }

    set idMotoboy(value) {
        this.id = value;
    }

}