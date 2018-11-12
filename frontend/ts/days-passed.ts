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
            month: dateInst.getMonth(),
            day: dateInst.getDate()
        };
    }

    export function countDaysPassedFromNewYear(monthEnd?: string|number): number {
        const monthLast: number = monthEnd ? +monthEnd : divideCurrentDate()['month'];
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

    export function isLeapYear(year?: string): boolean {
        const checkedYear = year || divideCurrentDate()['year'];
        return checkedYear % 4 === 0 || checkedYear % 400 === 0;
    }
}


class DaysPassed {
    private daysPassed: number = -1;

    public constructor(fromDate: string) {
        new DaysPassedValidator(fromDate).validate();
        this.countDaysPassed();
    }

    private countDaysPassed() {
        this.daysPassed = DateHelpers.countDaysPassedFromNewYear();
    }

    public getValue() {
        return this.daysPassed;
    }
}

class DaysPassedValidator {
    private readonly currentDate: object;
    private readonly fromYear: number;
    private readonly fromMonth: number;
    private readonly fromDay: number;

    public constructor(fromDate: string) {
        this.currentDate = DateHelpers.divideCurrentDate();
        [this.fromDay, this.fromMonth, this.fromYear] = fromDate.split('.').map((str) => +str);
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
        const isYearEqual = this.fromYear === this.currentDate['year'];
        // В Date месяц отсчитывается с 0
        const currentMonth = this.currentDate['month'] + 1;
        if (this.fromMonth > currentMonth && isYearEqual) {
            throw new Error('Неправильный параметр month');
        }
    }

    private checkIfDayInFuture() {
        const isMonthEqual = this.fromMonth === this.currentDate['month'] + 1;
        if (this.fromDay > this.currentDate['day'] && isMonthEqual) {
            throw new Error('Неправильный параметр day');
        }
    }
}

export default DaysPassed;
