let calendar = document.querySelector('.calendar')

const month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

isLeapYear = (year) => {
    return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) || (year % 100 === 0 && year % 400 ===0)
}

getFebDays = (year) => {
    return isLeapYear(year) ? 29 : 28
}

const generateCalendar = (month, year) => {

    let calendar_days = calendar.querySelector('.calendar-days')
    let calendar_header_year = calendar.querySelector('#year')

    let days_of_month = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]

    calendar_days.innerHTML = ''

    let currDate = new Date()

    let curr_month = `${month_names[month]}`
    month_picker.innerHTML = curr_month
    calendar_header_year.innerHTML = year

    // get first day of month
    
    let first_day = new Date(year, month, 1)

    for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
        let day = document.createElement('div')
        if (i >= first_day.getDay()) {
            day.classList.add('calendar-day-hover')
            day.innerHTML = i - first_day.getDay() + 1
            day.innerHTML += `<span></span>
                            <span></span>
                            <span></span>
                            <span></span>`
            if (i - first_day.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month === currDate.getMonth()) {
                day.classList.add('curr-date')
            }
        }
        calendar_days.appendChild(day)
    }
}

let month_list = calendar.querySelector('.month-list')

month_names.forEach((e, index) => {
    let month = document.createElement('div')
    month.innerHTML = `<div data-month="${index}">${e}</div>`
    month.querySelector('div').onclick = () => {
        month_list.classList.remove('show')
        curr_month.value = index

        console.log(index)
        generateCalendar(index, curr_year.value)
        
        resetread()
    }
    month_list.appendChild(month)
})

let month_picker = calendar.querySelector('#month-picker')

month_picker.onclick = () => {
    month_list.classList.add('show')
   
}

let currDate = new Date()

let curr_month = {value: currDate.getMonth()}
let curr_year = {value: currDate.getFullYear()}

generateCalendar(curr_month.value, curr_year.value)

document.querySelector('#prev-year').onclick = () => {
    --curr_year.value
    generateCalendar(curr_month.value, curr_year.value)
    resetread()
}

document.querySelector('#next-year').onclick = () => {
    ++curr_year.value
    generateCalendar(curr_month.value, curr_year.value)
    resetread()
}

const calendar_days = document.getElementsByClassName("calendar-day-hover")
//reset read will reset and rerun all the datas if teh data is clicked next or previous
function resetread(){
    for (let i = 0; i < calendar_days.length; i++) {
        calendar_days[i].addEventListener('click',choosingtargetdate)
    }
}
resetread()



const magicCalendar = document.querySelector('.magiccalendar');

magicCalendar.addEventListener('click', function (event) {
    if (event.target === magicCalendar) {
        // This block will execute only if the "magiccalendar" itself is clicked
        event.target.style.display = "none"
    }
});
var calledfunc = ""
const Databelow = document.querySelectorAll('.Databelow');
for (const element of Databelow) {
    element.addEventListener('click', function () {
        magicCalendar.style.display = "block"
        calledfunc = this.id
    });
}

function choosingtargetdate() {
    for (let i = 0; i < calendar_days.length; i++) {
        calendar_days[i].classList.remove("curr-date");
        this.classList.add("curr-date"); // Add the class to the clicked element
    }

    let targetiddate = document.getElementById(calledfunc)


    let paretnTIDD = targetiddate.parentNode.getAttribute("for")
    
    let targetinput = document.getElementById(paretnTIDD)
  
    const yearval = document.getElementById("year").innerText
    const monthpickerval = document.getElementById("month-picker").innerText

    //transform the string to DATE
    const STRINGDATE = `${monthpickerval} ${parseInt(this.innerText) } ${yearval}`
    const dateObject = new Date(STRINGDATE);
    const options = { timeZone: 'Asia/Taipei', year: 'numeric', month: '2-digit', day: '2-digit' };
    const formattedDate = dateObject.toLocaleDateString('en-US', options);

    const [month, day, year] = formattedDate.split('/');
    const yyyy_mm_dd = `${year}-${month}-${day}`;
    
   // const formattedDate = dateObject.toISOString().slice(0, 10); // Format the date as "YYYY-MM-DD"

    targetinput.value = yyyy_mm_dd;


    //take first letters of word
    const firstTHREELetters = monthpickerval.substring(0, 3);
    targetiddate.querySelector('.Number').innerHTML = this.innerText
    targetiddate.querySelector('.smallernumber').innerHTML =`/ ${firstTHREELetters} <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-352a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>`

    magicCalendar.style.display = "none"

}
