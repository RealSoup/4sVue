import Vue from 'vue'
import moment from 'moment'


Vue.filter('truncate', function (text, length, suffix) {
    return text.substring(0, length) + suffix;
});

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
});

Vue.filter('dateFormat', function (dt) {
    if (dt){
        // console.log(dt);
        // const date = new Date(dt);
        // const year = date.getFullYear();
        // let month = date.getMonth() + 1;
        // month = month > 9 ? month : `0${month}`;
        // const day = date.getDate();
        // let hours = date.getHours();
        // hours = hours > 9 ? hours : `0${hours}`;
        // const minutes = date.getMinutes();
        // return `${year}-${month}-${day} ${hours}:${minutes}`;
        const is_after = moment().isAfter(dt, 'year');
        let fm = '';
        if (moment().isSame(dt, 'day'))
            fm = 'HH:mm';
        else if (moment().isSame(dt, 'year'))
            fm = 'MM-DD';
        else
            fm = 'YY-MM-DD';

        return moment(String(dt)).format(fm);
    }

});
//
// export default {
//     filters: {
//         capitalize: function (value) {
//             if (!value) return ''
//             value = value.toString()
//             return value.charAt(0).toUpperCase() + value.slice(1)
//         },
//
//         dateFormat: function (dt) {
//             if (value) {
//                 return moment(String(value)).format('MM/DD/YYYY hh:mm')
//             }
//         },
//     }
// }
//
//
