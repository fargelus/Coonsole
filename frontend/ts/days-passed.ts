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

    function divideCurrentDate(): object {
        const dateInst: Date = new Date();
        return {
            year: dateInst.getFullYear(),
            month: dateInst.getMonth(),
            day: dateInst.getDay()
        };
    }

    export function getCurrentMonthNumber(): number {
        return divideCurrentDate()['month'];
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
    private readonly currentMonthNumber: number = 0;

    public constructor() {
        this.currentMonthNumber = DateHelpers.getCurrentMonthNumber();
    }

    public getValue() {
        return this.currentMonthNumber;
    }
}

export default DaysPassed;
