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
            month: dateInst.getMonth() + 1,
            day: dateInst.getDate()
        };
    }

    export function getDaysOfMonth(monthNumber: number): number {
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

    export function isLeapYear(year?: string): boolean {
        const checkedYear = year || divideCurrentDate()['year'];
        return checkedYear % 4 === 0 || checkedYear % 400 === 0;
    }
}


class DaysPassed {
    private readonly daysPassed: number = -1;
    private readonly currentDate: object;
    private readonly fromYear: number;
    private readonly fromMonth: number;
    private readonly fromDay: number;

    public constructor(fromDate: string) {
        this.currentDate = DateHelpers.divideCurrentDate();
        [this.fromDay, this.fromMonth, this.fromYear] = fromDate.split('.').map((str) => +str);

        this.checkIfDateInFuture();
    }

    private checkIfDateInFuture() {
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
        const isYearEqual = this.fromYear === this.currentDate['year'];
        if (this.fromMonth > this.currentDate['month'] && isYearEqual) {
            throw new Error('Неправильный параметр month');
        }
    }

    private checkIfDayInFuture() {
        const isMonthEqual = this.fromMonth === this.currentDate['month'];
        if (this.fromDay > this.currentDate['day'] && isMonthEqual) {
            throw new Error('Неправильный параметр day');
        }
    }

    public getValue() {
        return this.daysPassed;
    }
}

export default DaysPassed;
