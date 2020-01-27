import moment from 'moment'

export const conv2ThDate = date => {
  let arr = date.split('-')
  return arr[2] + '/' + arr[1] + '/' + (parseInt(arr[0]) + 543)
}

export const conv2DbDate = date => {
  let arr = date.split('/')
  return (parseInt(arr[2]) - 543) + '-' + arr[1] + '-' + arr[0]
}

export const getDate = (date) => {
  return moment(date).format('YYYY-MM-DD')
}
