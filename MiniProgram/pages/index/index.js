const util = require('../../utils/utils.js')

Page({
  data: {
    booksList: []
  },
  onLoad: function () {
    // 页面渲染后 执行
    util.get('https://www.helingfeng.com/novels').then((response)=> {
      this.setData({ booksList: response.data.data});
    });
  }
})
