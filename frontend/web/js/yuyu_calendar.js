/**
 * 	Author     : Lipinski Yury
 * 	E-mail     : lipinski.yury@gmail.com
 *  Created on : 20.11.2017
 *  
 *  
 *  Example use
 *
 *	<input type="text" class="yuyu-calendar" data-type="dateAndTime" name="">
 *
 * 	params  data-type:
 * 		""              - 08.12.2017;
 * 		dateAndTime  	- 15.12.2017 10:20:53;
 * 		longDate  	- 15 декабря 2017 г.;
 * 		shortDate       - 7.12.17;
 * 		dateString        - 2018-01-20;
 * 		ISO             - 2018-01-20T05:32:47.516Z
 * 	
 */




window.yuyuCalendar = (function () {

    var
            obj = {},
            classNameInput = 'yuyu-calendar',
            optionsTypeString = {
                default: {},
                dateAndTime: {},
                longDate: {year: 'numeric', month: 'long', day: 'numeric'},
                shortDate: {year: '2-digit', month: '2-digit', day: 'numeric'},
            },
            locale = 'ru-Ru',
            shell = {
                elements: {
                    inputElem: {},
                    container: document.createElement('div'),
                    grid: document.createElement('div'),
                    header: document.createElement('div'),
                    btnNextMonth: {},
                    btnPrevMonth: {},
                    btnNextYear: {},
                    btnPrevYear: {},
                    title: {}
                },
                html: {
                    header: '<svg class="yuyu-svg-btn" data-toggle="year"><path class="path-year" fill="none" d="M18 12 10 21 M10 20 18 28 M23 12 15 21 M15 20 23 28"></svg>' +
                            '<svg class="yuyu-svg-btn" data-toggle="month"><path class="path-month" fill="none" d="M18 12 10 21 M10 20 18 28"></svg>' +
                            '<div class="yuyu-header-title" data-toggle="title"></div>' +
                            '<svg class="yuyu-svg-btn" data-toggle="month"><path class="path-month" fill="none" d="M5 12 13 21 M13 20 5 28"></svg>' +
                            '<svg class="yuyu-svg-btn" data-toggle="year"><path class="path-year" fill="none" d="M5 12 13 21 M13 20 5 28 M10 12 18 21 M18 20 10 28"></svg>',
                    tableStart: '<table><tr><th>пн</th><th>вт</th><th>ср</th><th>чт</th><th>пт</th><th>сб</th><th>вс</th></tr><tr>'
                },
                css: '',
                init: function (year, month, daysOfWeek) {
                    var
                            i,
                            n,
                            _this = this,
                            allRootElem = [],
                            tagsInput = document.getElementsByTagName('input');

                    for (n = 0; n < tagsInput.length; n++) {
                        if (tagsInput[n].classList.contains(classNameInput)) {
                            allRootElem.push(tagsInput[n]);
                        }
                    }

                    tagsInput.length = 0;

                    for (i = 0; i < allRootElem.length; i++) {
                        allRootElem[i].addEventListener('click', createCalendar.bind(allRootElem[i]));
                    }


                    function createCalendar(e) {
                        var eventThis = this;

                        document.body.appendChild(_this.elements.container);
                        _this.elements.container.className = 'yuyu-calendar-container';
                        _this.elements.container.style.left = this.getBoundingClientRect().left + 'px';
                        _this.elements.container.style.top = this.getBoundingClientRect().bottom + 'px';

                        _this.elements.inputElem = this;


                        setTimeout(function () {
                            _this.elements.container.style.width = eventThis.getBoundingClientRect().width + 'px';
                            _this.elements.container.style.maxHeight = '300px';

                        }, 100);
                    }

                    obj = {};
                    obj = (year && month) ? new Calendar(year, month, daysOfWeek) : new Calendar(false, false, daysOfWeek);

                    _this.render();
                    _this.events();

                },
                render: function () {
                    var
                            _this = this,
                            elemStyle = document.createElement('style');

                    elemStyle.innerHTML = shell.css;
                    document.head.appendChild(elemStyle);


                    this.elements.container.appendChild(this.elements.header);
                    this.elements.container.appendChild(this.elements.grid);

                    this.elements.header.className = 'yuyu-calendar-header';
                    this.elements.header.innerHTML = this.html.header;

                    this.elements.grid.innerHTML = obj.table;

                    parseHeader();

                    function parseHeader() {
                        _this.elements.btnPrevYear = _this.elements.header.children[0];
                        _this.elements.btnPrevMonth = _this.elements.header.children[1];
                        _this.elements.title = _this.elements.header.children[2];
                        _this.elements.btnNextMonth = _this.elements.header.children[3];
                        _this.elements.btnNextYear = _this.elements.header.children[4];
                    }

                    this.elements.title.innerHTML = obj.title;

                },
                events: function () {
                    var
                            i,
                            elems,
                            that = this;

                    this.elements.btnPrevMonth.addEventListener('click', function (e) {
                        obj.month--;
                        shell.init(obj.year, obj.month, obj.dayOfWeek);
                    });

                    this.elements.btnNextMonth.addEventListener('click', function (e) {
                        obj.month++;
                        shell.init(obj.year, obj.month, obj.dayOfWeek);
                    });

                    this.elements.btnPrevYear.addEventListener('click', function (e) {
                        obj.year--;
                        shell.init(obj.year, obj.month, obj.dayOfWeek);
                    });

                    this.elements.btnNextYear.addEventListener('click', function (e) {
                        obj.year++;
                        shell.init(obj.year, obj.month, obj.dayOfWeek);
                    });

                    elems = this.elements.container.getElementsByClassName('yuyu-calendar-true-day');


                    for (i = 0; i < elems.length; i++) {
                        elems[i].addEventListener('click', clickDay.bind(elems[i]));
                    }

                    function clickDay(e) {

                        var type = that.elements.inputElem.dataset.type ? that.elements.inputElem.dataset.type : 'default';

                        obj.objDate.setDate(this.textContent);

                        if (type == 'dateAndTime') {
                            obj.title = obj.objDate.toLocaleDateString(locale, optionsTypeString[type]) + ' ' +
                                    obj.objDate.toLocaleTimeString(locale);
                        } else if (type == 'ISO') {
                            obj.title = obj.objDate.toISOString();
                        } else if (type == 'dateString') {
                            obj.title = obj.objDate.toDateString();
                        } else {
                            obj.title = obj.objDate.toLocaleDateString(locale, optionsTypeString[type]);
                        }

                        that.elements.title.innerHTML = obj.title;
                        that.elements.inputElem.value = obj.title;

                        var event = new CustomEvent("selectDate", {
                            detail: {value: obj.title}
                        });
                        document.dispatchEvent(event);
                        
                        exitCalendar();

                    }


                    document.addEventListener('click', getElementClick, true);

                    function getElementClick(event) {
                        var
                                isFind = false,
                                target = event.target;

                        // цикл двигается вверх от target к родителям до document
                        while (target != document) {
                            if (target.className == 'yuyu-calendar-container' || target.className == 'yuyu-calendar') {

                                isFind = true;
                                return;
                            }
                            target = target.parentNode;
                        }

                        if (!isFind) {
                            exitCalendar();
                        }

                    }

                    function exitCalendar() {
                        try {
                            if (that.elements.container && that.elements.container.className == 'yuyu-calendar-container') {
                                document.body.removeChild(that.elements.container);

//                                obj = {};
//                                var sh = Object.create(shell);
//                                sh.init();

                            }
                        } catch (err) {

                        }
                        ;

                    }

                },
                getData: function () {

                },
            }

    /**********************
     *    Calendar class
     **/


    function Calendar(year, month, daysOfWeek) {

        this.objDate = (year && month) ? new Date(year, month) : new Date();
        this.dayOfWeek = daysOfWeek;

        this.month = this.objDate.getMonth();
        this.year = this.objDate.getFullYear();
        this.currentDay = new Date().getDate();

        this.title;
        this.typeString;

        this.table = shell.html.tableStart;

        this.fillGrid();
        this.events();

    }


    Calendar.prototype.fillGrid = function () {
        // заполнить первый ряд от понедельника и до дня, с которого начинается месяц		
        var
                firstDayInGrid = this.getFirstDayInGrid(this.getDayOfWeek()),
                firstDayNextMonth = 1;

        this.objDate.setDate(1);

        for (var i = firstDayInGrid; i < firstDayInGrid + this.getDayOfWeek(); i++) {
            this.table += '<td class="yuyu-days-next-month">' + i + '</td>';
        }


        // ячейки календаря с датами
        while (this.objDate.getMonth() == this.month) {
            var cls = '';
            if (this.objDate.getDate() == this.currentDay) {
                cls = 'class="yuyu-calendar-select-day"';
            }
            if (this.dayOfWeek.indexOf(this.getDayOfWeek()) > -1) { // вс, последний день - перевод строки
                cls = 'class="yuyu-calendar-true-day"';
            }

            this.table += '<td ' + cls + '><div class="yuyu-calendar-day">' + this.objDate.getDate() + '</a></td>';



            if (this.getDayOfWeek() % 7 == 6) { // вс, последний день - перевод строки
                this.table += '</tr><tr>';
            }

            this.objDate.setDate(this.objDate.getDate() + 1);
        }



        // добить таблицу днями со следующего месяца, если нужно		
        if (this.getDayOfWeek() != 0) {
            for (var i = this.getDayOfWeek(); i < 7; i++) {
                this.table += '<td class="yuyu-days-next-month">' + firstDayNextMonth + '</td>';
                firstDayNextMonth++;
            }
        }


        this.objDate.setDate(this.currentDay);
        this.objDate.setMonth(this.month);
        this.objDate.setYear(this.year);
        this.title = this.objDate.toLocaleDateString('ru-RU', {year: 'numeric', month: 'long', day: 'numeric'})


        // закрыть таблицу
        this.table += '</tr></table>';

        // this.ev();		

    };

    Calendar.prototype.events = function () {

    };


    Calendar.prototype.getDayOfWeek = function () { // получить номер дня недели, от 0(пн) до 6(вс)
        var day = this.objDate.getDay();
        if (day == 0)
            day = 7;
        return day - 1;
    };
    Calendar.prototype.getFirstDayInGrid = function (numberDay) {
        // var lastDay = new Date(this.year, this.mon);
        var date = new Date(this.year, this.month);
        date.setDate(1 - numberDay);
        return date.getDate();
    };

    /**
     *  
     *************************/


//    shell.init(null,null,daysOfWeek);



    return {
        obj: obj,
        start: function (daysOfWeek) {
            shell.init(false, false, daysOfWeek);
        }
    };




}());