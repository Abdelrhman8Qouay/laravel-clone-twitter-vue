

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



// used to generate posts for this tutorial
var names = [{
    'tweet': 'This My Firsst post 😀 haaaai THia aJ Kj K Jk JK k KLGNklgN  GKLN GKLN GKLN gklnKLGN gkl...',
    'file': 'https://pbs.twimg.com/media/FxIx9QAWcAEZZHi?format=jpg&name=small',
    'is_video': false,
    'comments': 50,
    'retweets': 61,
    'likes': 1687,
    'analytics': 5164,
    'user': {
        'image': 'https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png',
        'description': 'Iam A front End Developer | FullStack (Laravel) >> aijdfk jakd jk afdkakdk jk aajs dfkj akjadf kjdak d kland aklnd klna dgklnklganlk dgkla ndkl ngkl nagklnlkagk ngk dsgakl',
        'name': 'Qouaynt Que',
        'handle': 'AbdelrhmanQouay',
        'is_following': false,
        'following': 320,
        'followers': 1250,
    }
},
{
    'tweet': 'This My Firsst post 😀 haaaai THia aJ Kj K Jk JK k KLGNklgN  GKLN GKLN GKLN gklnKLGN gkl...',
    'file': 'https://pbs.twimg.com/media/FxIx9QAWcAEZZHi?format=jpg&name=small',
    'is_video': false,
    'comments': 50,
    'retweets': 61,
    'likes': 1687,
    'analytics': 5164,
    'user': {
        'image': 'https://pbs.twimg.com/profile_images/1625184499582615563/XdG9pB_s_400x400.png',
        'description': 'Iam A front End Developer | FullStack (Laravel) >> aijdfk jakd jk afdkakdk jk aajs dfkj akjadf kjdak d kland aklnd klna dgklnklganlk dgkla ndkl ngkl nagklnlkagk ngk dsgakl',
        'name': 'Qouaynt Que',
        'handle': 'AbdelrhmanQouay',
        'is_following': false,
        'following': 320,
        'followers': 1250,
    }
},
{
    'tweet': 'This Is Second Post..... The Prophet',
    'file': './uploads/posts/videos/prophet_mousa.mp4',
    'is_video': true,
    'comments': 21,
    'retweets': 61,
    'likes': 21354687,
    'analytics': 123454687,
    'user': {
        'image': 'https://scontent.fcai20-2.fna.fbcdn.net/v/t39.30808-1/349117084_767214445071603_6250451640724122341_n.jpg?stp=dst-jpg_s200x200&_nc_cat=101&ccb=1-7&_nc_sid=7206a8&_nc_ohc=yWdGL2PIhzAAX-ck0C4&_nc_ht=scontent.fcai20-2.fna&oh=00_AfDZeoCWxUWMPtFeGJx_GQiz8F1H7RSXTamvzMO5oBbroA&oe=6477B3AC',
        'description': 'أهلاً بالجميع انا graphic designer',
        'name': 'Mayada Ashraf',
        'handle': 'MayadaAshraf',
        'is_following': true,
        'following': 604,
        'followers': 148987,
    }
}
];
// get Fake Posts With Infinity scroll Function
export const getPosts = (number) => {
    // generate a number of posts
    // in a real setting, this would be a database call or algorithm

    let posts = []

    for (var i = 0; i < number; i++) {
        posts.push(names[i % names.length]);
    }

    return posts;
  }
