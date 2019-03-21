
var bindInputIntegerValidation = (input, events = [], inputMin = null, inputMax = null) => {
    events.forEach((inputEvent) => {
        input.addEventListener(inputEvent, (event) =>{
            if(inputMin && event.target.value < inputMin){
                event.target.value = inputMin;
            } else if(inputMax && event.target.value > inputMax) {
                event.target.value = inputMax;
            }

            if(event.target.value >= inputMin) {
                event.target.value = parseInt(event.target.value);
                event.target.classList.add('is-valid');
            }
            else {
                event.target.value = parseInt(event.target.value);
                event.target.classList.remove('is-valid');
                event.preventDefault();
            }
        });
    });
};

var bindTextInputValidation = (input, events = [], minLength = null, maxLength = null) => {
    events.forEach( (inputEvent) => {
        input.addEventListener(inputEvent, (event) => {
            if(minLength && maxLength && event.target.value.length < minLength || event.target.value.length > maxLength) {
                event.target.classList.remove('is-valid');
            } else {
                event.target.classList.add('is-valid');
            }
        });
    });
};

//input latitude and longitude
var bindLatLngInputsValidation = (events = [], latInput, lngInput, defaultLatLngValue) => {
    events.forEach((inputEvent) => {
        [latInput, lngInput].forEach((input) => {
            input.addEventListener(inputEvent, () => {
                let _lat = parseFloat(latInput.value);
                let _lng = parseFloat(lngInput.value);

                if(isNaN(_lat)) _lat = defaultLatLngValue;
                else {
                    if(_lat < -90) _lat = -90;
                    if(_lat > 90) _lat = 90;
                }
                if(isNaN(_lng)) _lng = defaultLatLngValue;
                else {
                    if(_lng < -180) _lng = -180;
                    if(_lng > 180) _lng = 180;
                }
                latInput.value = _lat.toFixed(6);
                lngInput.value = _lng.toFixed(6);
                if(latInput && lngInput ){
                    [latInput, lngInput].forEach((elt) => {
                        elt.classList.add('is-valid');
                    });
                    centerMap(_lat.toFixed(6), _lng.toFixed(6));
                }
            });
        });
    });
};
