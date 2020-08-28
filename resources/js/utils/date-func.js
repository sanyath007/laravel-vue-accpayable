import moment from 'moment'

export const conv2ThDate = date => {
  let [year, month, day] = date.split('-')
  return day + '/' + month + '/' + (parseInt(year) + 543)
}

export const conv2DbDate = date => {
  let [day, month, year] = date.split('/')
  console.log('year', year)
  return (parseInt(year) - 543) + '-' + month + '-' + day
}

export const getDate = (date) => {
  return moment(date).format('YYYY-MM-DD')
}
