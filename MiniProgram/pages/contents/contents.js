const util = require('../../utils/utils.js')

Page({
  data: {
    chapter: {},
  },
  onLoad: function (options) {
    // 页面渲染后 执行
    util.get('https://www.helingfeng.com/novels/' + options.book_id + '/chapters/' + options.chapter_id).then((response) => {
      this.setData({ chapter: response.data });
    });
  }
})
