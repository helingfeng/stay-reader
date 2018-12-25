const util = require('../../utils/utils.js')

Page({
  data: {
    chaptersList: [],
    book_id: 0,
  },
  onLoad: function (options) {
    // 页面渲染后 执行
    util.get('https://www.helingfeng.com/novels/' + options.book_id + '/chapters').then((response) => {
      this.setData({ chaptersList: response.data });
      this.setData({ book_id: options.book_id });
    });
  }
})
