
window.onload = function () {
    console.dir(window.yuyuCalendar);
    initCalendar.go();
};

$(document).on('pjax:complete', function () {
    initCalendar.go();
});


var initCalendar = (function () {

    var startCalendar = function () {
        var
                dayOfWeek,
                msUTC,
                scheduleClass = document.getElementById('schedule-class_id'),
                inputDate = document.getElementById('schedule-date'),
                inputCalendar = document.getElementById('input_yuyu_calendar');

        if (scheduleClass) {
            scheduleClass.addEventListener('change', showCalendar);
        }

        function showCalendar() {
            dayOfWeek = this.selectedOptions[0].dataset.dayweek;
            window.yuyuCalendar.start([Number(dayOfWeek) - 1]);
        }


        /*****************************
         *	Observer
         **/

        var
                observerObj,
                observerEvents = {
                    selectDate: {
                        name: 'selectDate',
                        action: selectDate
                    }
                };

        function Observer(eventName, action) {
            this.onDataCompleted = action;
            this.handlerRef = this.onDataCompleted.bind(this);
            this.toggle(eventName);
        }

        Observer.prototype.toggle = function (eventName) {
            for (var key in observerEvents) {
                if (eventName == observerEvents[key].name) {
                    document.addEventListener(observerEvents[key].name, this.handlerRef);
                }
            }
        };

        function dataObjFactory() {
            for (var key in observerEvents) {
                if (observerObj) {
                    document.removeEventListener(observerEvents[key].name, observerObj.handlerRef);
                }
                observerObj = new Observer(observerEvents[key].name, observerEvents[key].action);
            }
        }

        dataObjFactory();

        /**
         *	Observer
         ******************************/

        function selectDate(observerEvent) {
            msUTC = rounding(Date.parse(observerEvent.detail.value), 1000);
            inputDate.value = inputCalendar.value ? msUTC : '';
        }
        
        function rounding(a, b) {
            return (a - a % b) / b;
        }

    };

    return {go: startCalendar};
})();




