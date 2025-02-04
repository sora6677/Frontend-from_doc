//type: 1: 單選radio, 2: 複選checkbox, 3:text問答, 4:table表單
const data = [
  {
    id: 110000,
    type: 1,
    content: "請問您的性別？",
    answer: {
      radio: [
        { answer: "男性", text: false },
        { answer: "女性", text: false },
        { answer: "其他", text: false },
      ],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 120000,
    type: 1,
    content: "請問您的年齡為",
    answer: {
      radio: [
        { answer: "18歲以下", text: false },
        { answer: "19-22歲", text: false },
        { answer: "23-25歲", text: false },
        { answer: "26-30歲", text: false },
        { answer: "31-40歲", text: false },
        { answer: "41-50歲", text: false },
        { answer: "51歲以上", text: false },
      ],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 130000,
    type: 1,
    content: "請問您的居住地",
    answer: {
      radio: [
        { answer: "台中市", text: false },
        { answer: "中部地區(台中市外)", text: false },
        { answer: "北部地區", text: false },
        { answer: "南部地區", text: false },
        { answer: "東部地區", text: false },
        { answer: "離島", text: false },
        { answer: "海外人士", text: false },
      ],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 140000,
    type: 1,
    content: "請問您如何抵達活動會場？",
    answer: {
      radio: [
        { answer: "自行開車", text: false },
        { answer: "騎摩托車", text: false },
        { answer: "騎自行車（含IBike）", text: false },
        { answer: "搭乘捷運", text: false },
        { answer: "搭乘公車", text: false },
        { answer: "搭乘復康巴士", text: false },
        { answer: "其它", text: true },
      ],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 150000,
    type: 2,
    content:
      "請問您一年內是否曾參與其他音樂祭？(可複選，勾選其他請填寫音樂祭名稱)",
    answer: {
      radio: [],
      checkbox: [
        { answer: "大港開唱", text: false },
        { answer: "河海音樂祭", text: false },
        { answer: "浪人祭", text: false },
        { answer: "浮現祭", text: false },
        { answer: "其他", text: true },
      ],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 160000,
    type: 3,
    content: "您認為搖滾台中與其他音樂祭最大的差別？",
    answer: {
      radio: [],
      checkbox: [],
      table: {},
      text: "",
    },
  },
  {
    id: 170000,
    type: 1,
    content: "請問您從何處得知搖滾台中的相關消息？",
    answer: {
      radio: [
        { answer: "搖滾台中Facebook官方粉絲專頁", text: false },
        { answer: "親朋好友推薦", text: false },
        { answer: "傳單/海報", text: false },
        { answer: "台中市政府網站/社群媒體/Mail", text: false },
        {
          answer: "藝人網站或藝人Facebook專頁，請寫出藝人名：",
          text: true,
        },
        { answer: "現場經過", text: false },
        { answer: "電視或廣播", text: false },
        { answer: "其它", text: true },
      ],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 180000,
    type: 2,
    content: "您會參加搖滾台中的原因是(可複選)？",
    answer: {
      radio: [],
      checkbox: [
        { answer: "演出陣容", text: false },
        { answer: "友人推薦或邀約", text: false },
        { answer: "現場經過", text: false },
        { answer: "周末休閒活動", text: false },
        { answer: "免費活動有興趣", text: false },
        { answer: "其他", text: true },
      ],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 190000,
    type: 4,
    content: "本次主要吸引你的活動內容為？",
    answer: {
      radio: [],
      checkbox: [],
      table: {
        answer: [
          {
            content: "演出陣容",
            id: 191000,
          },
          {
            content: "樂團現場演出",
            id: 192000,
          },
          {
            content: "市集規劃",
            id: 193000,
          },
          {
            content: "親子活動",
            id: 194000,
          },
          {
            content: "整體音樂節氣氛",
            id: 195000,
          },
          {
            content: "場地規劃",
            id: 196000,
          },
        ],
        radio: ["非常不同意", "不同意", "普通", "同意", "非常同意"],
      },
      text: "",
    },
  },
  {
    id: 200000,
    type: 1,
    content:
      "請問您是否會向朋友推薦搖滾台中活動？  10為絕對推薦，1為絕對不推薦。",
    answer: {
      radio: [],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
      select: [10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
    },
  },
  {
    id: 210000,
    type: 1,
    content: "假設明年的搖滾台中不是免費入場，請問你願意花費多少元買票入場呢？",
    answer: {
      radio: [
        { answer: "新台幣", text: false, number: true },
        { answer: "不會，我只想參加免費音樂祭", text: false },
      ],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 220000,
    type: 1,
    content: "請問您認為本次搖滾台中有什麼可改善的地方？",
    answer: {
      radio: [
        { answer: "演出內容品質", text: false },
        { answer: "市集攤販內容", text: false },
        { answer: "動線規劃", text: false },
        { answer: "廁所", text: false },
        { answer: "垃圾與資源回收安排", text: false },
        { answer: "活動宣傳", text: false },
        { answer: "其他", text: true },
      ],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 230000,
    type: 1,
    content: "請問你認為這次活動對於高齡者、身障者以及孕婦孩童是否友善？",
    answer: {
      radio: [
        { answer: "是", text: false },
        { answer: "否，原因", text: true },
      ],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 240000,
    type: 1,
    content:
      "請問這次參與搖滾台中，周邊消費金額共累積多少?(包含車資、住宿、飲食、消費等)",
    answer: {
      radio: [
        { answer: "500元以下", text: false },
        { answer: "501   ~1,000元", text: false },
        { answer: "1,001 ~2,000元", text: false },
        { answer: "2,001 ~3,000元", text: false },
        { answer: "3,001元以上", text: false },
      ],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 250000,
    type: 3,
    content:
      "請問未來希望搖滾台中可以邀請哪些樂團(或歌手)來演出? （國內外不拘）",
    answer: {
      radio: [],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
  {
    id: 260000,
    type: 3,
    content: "請留下對本次搖滾台中的任何寶貴意見。",
    answer: {
      radio: [],
      checkbox: [],
      table: {
        answer: [],
        radio: [],
      },
      text: "",
    },
  },
];

const answer = [
  {
    id: 110000,
    type: 1,
    answer: {
      select: 1,
      fill: "",
    },
  },
  {
    id: 120000,
    type: 1,
    answer: {
      select: 2,
      fill: "",
    },
  },
  {
    id: 130000,
    type: 1,
    answer: {
      select: 2,
      fill: "",
    },
  },
  {
    id: 140000,
    type: 1,
    answer: {
      select: 6,
      fill: "",
    },
  },
  {
    id: 150000,
    type: 2,
    answer: {
      select: [4, 5],
      fill: {
        5: "多選回答",
      },
    },
  },
  {
    id: 160000,
    type: 3,
    answer: {
      fill: "回答答案1",
    },
  },
  {
    id: 170000,
    type: 1,
    answer: {
      select: 4,
      fill: "",
    },
  },
  {
    id: 180000,
    type: 2,
    answer: {
      select: [2, 3],
      fill: {},
    },
  },
  {
    id: 190000,
    type: 4,
    answer: {
      select: [
        {
          191000: 1,
          192000: 2,
          193000: 2,
          194000: 3,
          195000: 4,
          196000: 5,
        },
      ],
    },
  },
  {
    id: 200000,
    type: 1,
    answer: {
      select: 9,
      fill: "",
    },
  },
  {
    id: 210000,
    type: 1,
    answer: {
      select: 2,
      fill: "",
    },
  },
  {
    id: 220000,
    type: 1,
    answer: {
      select: 4,
      fill: "",
    },
  },
  {
    id: 230000,
    type: 1,
    answer: {
      select: 1,
      fill: "",
    },
  },
  {
    id: 240000,
    type: 1,
    answer: {
      select: 1,
      fill: "",
    },
  },
  {
    id: 250000,
    type: 3,
    answer: {
      fill: "回答答案2",
    },
  },
  {
    id: 260000,
    type: 3,
    answer: {
      fill: "回答答案3",
    },
  },
];
