
// get the between times Function
export const betweenTime = function(timeString) {
    let date = new Date(); // current time
    let targetDate = new Date(timeString); // static time

    let milliseconds = date - targetDate;
    let seconds = Math.floor(milliseconds / 1000);
    let minutes = Math.floor(seconds / 60);
    let hours = Math.floor(minutes / 60);
    let days = Math.floor(hours / 24);
    let months = Math.floor(days / 30);
    let years = Math.floor(months / 12);

    let monthsArr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let symb = 's';
    let whenTime = 0;
    let toStringed = targetDate.toDateString().split(' ');

    // Conditions To Handle Time
    if(seconds <= 60) {
        symb = 's';
        whenTime = seconds;
    } else if (minutes <= 60 && minutes > 0 ) {
        symb = 'm';
        whenTime = minutes;
    } else if (hours <= 24 && hours > 0) {
        symb = 'h';
        whenTime = hours;
    } else if (days <= 30 && days > 0) {
        symb = 'd';
        whenTime = days;
    }else if (months <= 12 && months > 0) {
        symb = '';
        whenTime = toStringed[1] + ' ' + toStringed[2];
    }else if (years <= 12 && years > 0) {
        symb = 'Y';
        whenTime = toStringed[1] + ' ' + toStringed[2] + ' ' + toStringed[3];
    } else {
        symb = 'NN';
        whenTime = 405;
        console.log('Method betweenTime Not Work Some Problem');
    }
    return whenTime + symb;
}


// Format Number Function
export const formatNumber = function(num) {
    if(num == undefined) return;

    // if not a number so, change to an integer type
    if(isNaN(num)) parseInt(num);

    let beforeEnd = '';
    if(num >= 10000) beforeEnd = num.toLocaleString().split(',')[1].split('').slice(0, 2).join('');

	let formater = num.toLocaleString().split(',')[0] + ',' + beforeEnd;

    if(num < 10000) {
        return num.toLocaleString();
    }else if(num >= 10000 && num < 1000000) {
		return formater + 'K';
    }else if(num >= 1000000 && num < 1000000000) {
		return formater + 'M';
    }else if(num >= 1000000000 && num < 1000000000000) {
		return formater + 'B';
    }
    // Example: num = 12540000 >> after >> 12,54M
}

// format bytes Function
export const formatBytes = function(bytes, decimals = 2) {
    if (!+bytes) return "0 Bytes";

    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = [
        "Bytes",
        "KiB",
        "MiB",
        "GiB",
        "TiB",
        "PiB",
        "EiB",
        "ZiB",
        "YiB",
    ];

    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
}


// is scrolled into view >>> to check if the user stop on specific ele or no
// export const isScrolledIntoView = function( element, container ) {
//     var elementTop    = element.getBoundingClientRect().top,
//         elementBottom = element.getBoundingClientRect().bottom;

//     // console.log(`window: innerHeight>>${window.innerHeight} outerHeight>>${window.outerHeight} -- ele: top>>${element.getBoundingClientRect().top} height>>${element.getBoundingClientRect().height} -- container: scrollHeight>>${container.scrollHeight} clientHeight>>${container.clientHeight} clientTop>>${container.clientTop}`);
//     console.log(element.getBoundingClientRect().y);
//     return elementTop >= 0 && elementBottom <= container.innerHeight;
// }
