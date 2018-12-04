# StayReader

单纯想打造属于自己的一款阅读工具📱，免去付费和广告的烦恼🤷‍♀️。

自己写代码采集书籍📚，通过微信小程序进行阅览

基于 Laravel + DomCrawler 数据采集程序

- 分页下载网站的 TXT 大文件，并对文件进行正则匹配转换为章节内容
- 直接采集 HTML 原始页面，进行 DOM 解析，提取页面匹配元素
- 分层过滤，异常捕获


## 开放 API 接口
 
### 获取小说列表
 
- https://www.helingfeng.com/novels

实例返回结果：
```markdown
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "book_id": 9591,
            "name": "山河阙",
            "author": "莫念秋",
            ...
        }
    ],
    "first_page_url": "https://www.helingfeng.com/novels?page=1",
    "from": 1,
    "next_page_url": "https://www.helingfeng.com/novels?page=2",
    "path": "https://www.helingfeng.com/novels",
    "per_page": "1",
    "prev_page_url": null,
    "to": 1
}
```

### 获取小说详情

- https://www.helingfeng.com/novels/9591

实例返回结果：
```markdown
{
    "id": 1,
    "book_id": 9591,
    "name": "山河阙",
    "author": "莫念秋",
    ...
}
```

### 获取小说所有章节

- https://www.helingfeng.com/novels/9591/chapters

实例返回结果：
```markdown
{
    "1": "第五章 盘问",
    "2": "第一章 十万雪域",
    "3": "第二章 奸细",
    ...
}
```

### 获取小说章节内容

- https://www.helingfeng.com/novels/9591/chapters/2

实例返回结果：
```markdown
{
    "id": 2,
    "book_id": 9591,
    "chapter": "第一章 十万雪域",
    "contents": "现在，是寒冬腊月。此时，是傍晚，没有夕阳。十万雪域...",
    "modified_date": "2018-12-04 07:38:31",
    "created_date": "2018-12-04 07:38:31"
}
```