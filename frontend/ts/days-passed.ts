namespace DateHelpers {
    enum Month {
        January,
        February,
        March,
        April,
        May,
        June,
        July,
        August,
        September,
        October,
        November,
        December
    }

    export function divideCurrentDate(): object {
        const dateInst: Date = new Date();
        return {
            year: dateInst.getFullYear(),
            // В Date месяц отсчитывается с 0
            month: dateInst.getMonth() + 1,
            day: dateInst.getDate()
        };
    }

    export function countDaysPassedFromNewYear(monthEnd?: string|number): number {
        // Сравниваем с undef, так как 0 также валидный месяц
        const monthLast: number = monthEnd !== undefined ? +monthEnd : divideCurrentDate()['month'];
        return new Array(monthLast)
                   .fill(undefined)
                   .map((_: undefined, index: number) => getDaysOfMonth(index))
                   .reduce((acc, current) => acc + current);
    }

    function getDaysOfMonth(monthNumber: number): number {
        if (monthNumber === Month.February) {
            return isLeapYear() ? 29 : 28;
        }

        if (monthNumber < Month.August) {
            if (monthNumber % 2 === 0) return 31;
            else return 30;
        } else {
            if (monthNumber % 2 === 1) return 31;
            else return 30;
        }
    }

    export function isLeapYear(year?: string|number): boolean {
        const checkedYear = year || divideCurrentDate()['year'];
        return checkedYear % 4 === 0 || checkedYear % 400 === 0;
    }
}


class DaysPassedBase {
    protected currentDate: object;
    protected fromYear: number;
    protected fromMonth: number;
    protected fromDay: number;

    protected constructor(fromDate: string) {
        this.currentDate = DateHelpers.divideCurrentDate();
        [this.fromDay, this.fromMonth, this.fromYear] = fromDate.split('.').map((str) => +str);
    }

    protected isMonthEqual(): boolean {
        return this.fromMonth === this.currentDate['month'];
    }

    protected isYearEqual(): boolean {
        return this.fromYear === this.currentDate['year'];
    }
}

class DaysPassed extends DaysPassedBase {
    private daysPassed: number = -1;

    public constructor(fromDate: string) {
        super(fromDate);
        new DaysPassedValidator(fromDate).validate();
        this.countDaysPassed();
    }

    private countDaysPassed() {
        let dayWithinCurrentYear: number = DateHelpers.countDaysPassedFromNewYear() + this.currentDate['day'];
        let dayWithinReceiveYear: number = DateHelpers.countDaysPassedFromNewYear(this.fromMonth);
        dayWithinReceiveYear += this.fromDay;

        const isYearsDiffer: boolean = !this.isYearEqual();
        if (isYearsDiffer) {
            // Аккумулируем значения дней прошедших лет
            this.daysPassed = dayWithinCurrentYear + this.countDaysPassedConsiderYears();
        } else {
            // Подсчет дней, прошедших с текущей даты
            this.daysPassed = dayWithinCurrentYear - dayWithinReceiveYear;
        }
    }

    private countDaysPassedConsiderYears(): number {
        // Выясним сколько дней до следующего НГ
        let daysAcc: number = 365 - DateHelpers.countDaysPassedFromNewYear(this.fromMonth) - this.fromDay;
        if (DateHelpers.isLeapYear(this.fromYear)) {
            daysAcc += 1;
        }

        let yearIt: number = this.fromYear + 1;
        while (yearIt < this.currentDate['year']) {
            daysAcc += DateHelpers.isLeapYear(yearIt) ? 366 : 365;
            yearIt += 1;
        }

        // Сейчас daysAcc содержит кол-во дней прошедщих до 1 января тек.года
        return daysAcc;
    }

    public getValue() {
        return this.daysPassed;
    }
}

class DaysPassedValidator extends DaysPassedBase {
    public constructor(fromDate: string) {
        super(fromDate);
    }

    public validate() {
        this.checkIfYearInFuture();
        this.checkIfMonthInFuture();
        this.checkIfDayInFuture();
    }

    private checkIfYearInFuture() {
        if (this.fromYear > this.currentDate['year']) {
            throw new Error('Неправильный параметр year');
        }
    }

    private checkIfMonthInFuture() {
        if (this.fromMonth > this.currentDate['month'] && this.isYearEqual()) {
            throw new Error('Неправильный параметр month');
        }
    }

    private checkIfDayInFuture() {
        if (this.fromDay > this.currentDate['day'] && this.isMonthEqual()) {
            throw new Error('Неправильный параметр day');
        }
    }
}

export default DaysPassed;
