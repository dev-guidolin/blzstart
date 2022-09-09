import got from 'got';
const timer = ms => new Promise(res => setTimeout(res, ms))

async function start (){

const url = "https://blaze.com/api/roulette_games/recent/history?page=1";

    var id = "";
    while(true){
        const data = await got.get(url).json();
        
        let resposta =  Object.values(data.records)[0];

        if(resposta.id !== id){
            const urlPost = "https://d8c7-177-149-159-88.sa.ngrok.io/api/blaze/double/resultado"

             const post = await got.post(urlPost,{
                 json: data
             }).json();

             console.log(post)
    
             id = resposta.id;
        }
        await timer(2000);

    }
}

start();
