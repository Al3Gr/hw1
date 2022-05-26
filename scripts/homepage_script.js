fetch("http://localhost/HW1/ajax_momentOfDay.php").then(onResponse).then(onJsonWeather)

function onResponse(response){
    return response.json()
}

function onJsonWeather(json){
    const hour = json.current.last_updated.slice(11, 13)
    const weatherInfo = json.current.condition.text + ', ' + json.current.temp_c + '°C'
    const icon = json.current.condition.icon
    const city = json.location.name 

    const h1 = document.querySelector("#momentOfDay")
    if(hour < 12) {
        h1.textContent = "Buongiorno"
    } else {
        h1.textContent = "Buonasera"
    }

    const h2 = document.querySelector("#weather_info h2")
    h2.textContent = city

    const p = document.querySelector("#weather_info p")
    p.textContent = weatherInfo

    const img = document.querySelector("#weather_info img")
    img.src = "http:"+icon

}

const body = document.querySelector("body")

const post_button = document.querySelector("#create_post_button")
post_button.addEventListener("click", openPostForm)
const delete_button = document.querySelector(".delete_post")
delete_button.addEventListener("click", closePostForm)

function openPostForm(event){
    const overlay = document.querySelector("#add_post")
    overlay.classList.remove("hidden")
}

function closePostForm(event){
    const overlay = document.querySelector(".overlay")
    const title = document.querySelector(".title_post")
    const textarea = document.querySelector(".comment_post")
    title.value=""
    textarea.value=""
    overlay.classList.add("hidden")
}


const profile = document.querySelector("#profile")
profile.addEventListener("click", profileInfoMenu)

function profileInfoMenu(event) {
    const infoMenu = document.querySelector("#profile_info")
    if(infoMenu.classList.contains("hidden")) {
        infoMenu.classList.remove("hidden")
    } else {
        infoMenu.classList.add("hidden")
    }
}


function openCommentSection(event){
    console.log("openCommentSection")
    const post = event.currentTarget.parentNode.parentNode.parentNode
    const comments_section = post.querySelector(".comments_section")
    if(comments_section.classList.contains("hidden")) {
        event.currentTarget.classList.add("comment_button_selected")
        comments_section.classList.remove("hidden")
    } else {
        event.currentTarget.classList.remove("comment_button_selected")
        comments_section.classList.add("hidden")
    }
}

function writeComment(event){
    const comments_section = event.currentTarget.parentNode.parentNode
    console.log(comments_section)
    const insert_comment = comments_section.querySelector(".insert_comment")
    const utility_comment = comments_section.querySelector(".utility_comments_section")

    insert_comment.classList.remove("hidden")
    utility_comment.classList.add("hidden")
}

function deletePost(event){
    const article = document.querySelector("article")
    const post = event.currentTarget.parentNode.parentNode.parentNode
    article.removeChild(post)
    fetch("removePost.php?q="+encodeURIComponent(post.dataset.id))
}

fetch("getPost.php?q="+encodeURIComponent(profile.dataset.username)).then(onResponse).then(createPost)

function createPost(json){
    const article = document.querySelector("article")
    
    for(let i of json){

        console.log(i)

        const post = document.createElement("section")
        post.classList.add("post")
        post.dataset.id = i.id

        const upper_section = createUpperSection(i.title, i.username, i.publish_date)
        const hr1 = document.createElement("hr")
        const middle_section = createMiddleSection(i.content)
        const hr2 = document.createElement("hr")
        const lower_section = createLowerSection(i.num_likes, i.num_comments, i.ok)
        const comment_section = createCommentSection(i.id)

        post.appendChild(upper_section)
        post.appendChild(hr1)
        post.appendChild(middle_section)
        post.appendChild(hr2)
        post.appendChild(lower_section)
        post.appendChild(comment_section)
        
        
        
        article.appendChild(post)

    }
}

function createUpperSection(h1_argument, p_argument, date_argument){
    const upper_section = document.createElement("div")
    upper_section.classList.add("upper_section")


    const title = document.createElement("div")
    title.classList.add("title")

    const h1 = document.createElement("h1")
    h1.textContent = h1_argument

    const p = document.createElement("p")
    p.textContent = '@'+p_argument

    title.appendChild(h1)
    title.appendChild(p)

    const date = document.createElement("p")
    date.textContent= "Pubblicato il: "+date_argument

    upper_section.appendChild(title)
    upper_section.appendChild(date)


    return upper_section 
}

function createMiddleSection(comment_argument){
    const middleSection = document.createElement("div")
    middleSection.classList.add("middle_section")


    const comment = document.createElement("p")
    comment.textContent = comment_argument

    middleSection.appendChild(comment)

    return middleSection
}

function createLowerSection(num_likes, num_comments, ok){
    const lowerSection = document.createElement("div")
    lowerSection.classList.add("lower_section")

    const div_1 = document.createElement("div")
    const div_2 = document.createElement("div")

    const like_button = document.createElement("button")
    like_button.classList.add("button")
    like_button.classList.add("like")
    const sp_like = document.createElement("span")
    sp_like.classList.add("material-icons")
    if (ok) {
        sp_like.textContent="favorite"
        like_button.classList.add("like_button_selected")
    } else {
        sp_like.textContent="favorite_border"
    }
    const p_like = document.createElement("p")
    p_like.textContent = num_likes
    like_button.appendChild(sp_like)
    like_button.appendChild(p_like)

    like_button.addEventListener('click', like)

    const comment_button = document.createElement("button")
    comment_button.classList.add("button")
    comment_button.classList.add("comment_button")
    comment_button.addEventListener('click', openCommentSection)
    const sp_comment = document.createElement("span")
    sp_comment.classList.add("material-icons")
    sp_comment.textContent="chat_bubble_outline"
    const p_comment = document.createElement("p")
    p_comment.textContent = num_comments
    comment_button.appendChild(sp_comment)
    comment_button.appendChild(p_comment)

    const edit_button = document.createElement("button")
    edit_button.classList.add("button")
    edit_button.classList.add("edit")
    edit_button.addEventListener('click', modifyPost)
    const sp_edit = document.createElement("span")
    sp_edit.classList.add("material-icons")
    sp_edit.textContent="edit_note"
    edit_button.appendChild(sp_edit)

    const delete_button = document.createElement("button")
    delete_button.classList.add("button")
    delete_button.classList.add("delete")
    delete_button.addEventListener("click", deletePost)
    const sp_delete = document.createElement("span")
    sp_delete.classList.add("material-icons")
    sp_delete.textContent="delete_outline"
    delete_button.appendChild(sp_delete)


    div_1.appendChild(like_button)
    div_1.appendChild(comment_button)
    div_2.appendChild(edit_button)
    div_2.appendChild(delete_button)

    lowerSection.appendChild(div_1)
    lowerSection.appendChild(div_2)

    return lowerSection
}

function createCommentSection(post_id){
    
    const comment_section = document.createElement("div")
    comment_section.classList.add("comments_section")
    comment_section.classList.add("hidden")

    const hr = document.createElement("hr")
    comment_section.appendChild(hr)

    const insert_comment = document.createElement("form")
    insert_comment.action="addCommentToPost.php"
    insert_comment.method="post"
    insert_comment.classList.add("insert_comment")
    insert_comment.classList.add("hidden")

    const textarea = document.createElement("textarea")
    textarea.name="comment"

    const div = document.createElement("div")

    const post_comment = document.createElement("button")
    post_comment.classList.add("button")
    post_comment.classList.add("add_comment")
    //post_comment.addEventListener('click', addCommentToPost)

    const sp_post_comment = document.createElement("span")
    sp_post_comment.classList.add("material-icons")
    sp_post_comment.textContent="navigate_next"

    post_comment.appendChild(sp_post_comment)
    

    const close_comment = document.createElement("button")
    close_comment.classList.add("button")
    close_comment.classList.add("add_comment")
    close_comment.addEventListener('click', close_InsertComment)

    const sp_close_comment = document.createElement("span")
    sp_close_comment.classList.add("material-icons")
    sp_close_comment.textContent="close"

    close_comment.appendChild(sp_close_comment)

    div.appendChild(post_comment)
    div.appendChild(close_comment)

    const hidden_input_1 = document.createElement("input")
    hidden_input_1.name="post_id"
    hidden_input_1.type="hidden"
    hidden_input_1.value=post_id

    const hidden_input_2 = document.createElement("input")
    hidden_input_2.name="user"
    hidden_input_2.type="hidden"
    hidden_input_2.value=profile.dataset.username


    insert_comment.appendChild(textarea)
    insert_comment.appendChild(hidden_input_1)
    insert_comment.appendChild(hidden_input_2)
    insert_comment.appendChild(div)

    comment_section.appendChild(insert_comment)

    const utility = document.createElement("div")
    utility.classList.add("utility_comments_section")

    const p1 = document.createElement("p")
    p1.textContent="Commenti"

    const add_comment = document.createElement("button")
    add_comment.classList.add("button")
    add_comment.classList.add("add_comment")
    add_comment.addEventListener("click", writeComment)
    const sp_add_comment = document.createElement("span")
    sp_add_comment.classList.add("material-icons")
    sp_add_comment.textContent="add"

    add_comment.appendChild(sp_add_comment)

    utility.appendChild(p1)
    utility.appendChild(add_comment)

    comment_section.appendChild(utility)

    fetch("getCommentsForPost.php?q="+encodeURIComponent(post_id)).then(onResponse).then(onJsonComment)

    return comment_section
}

function close_InsertComment(event){
    event.preventDefault()

    const insert_comment = event.currentTarget.parentNode.parentNode
    const comment_section = insert_comment.parentNode
    const utility_comments_section = comment_section.querySelector(".utility_comments_section")
    const textarea = insert_comment.querySelector("textarea")
    console.log(textarea)

    textarea.value=""
    insert_comment.classList.add("hidden")
    utility_comments_section.classList.remove("hidden")
    
}

// function addCommentToPost(event){
//     event.preventDefault()
//     //fetch("addCommentToPost.php")
//     const section = event.currentTarget.parentNode.parentNode
//     console.log(section)
// }

function like(event){
    const like_button = event.currentTarget
    const icon = like_button.querySelector("span")
    const post = like_button.parentNode.parentNode.parentNode

    if(!like_button.classList.contains("like_button_selected")) {
        like_button.classList.add("like_button_selected")
        icon.textContent="favorite"
        fetch("addLikeToPost.php?id="+encodeURIComponent(post.dataset.id)+"&user="+encodeURIComponent(profile.dataset.username)).then(onResponse).then(onJsonLike)
        
    } else {
        like_button.classList.remove("like_button_selected")
        icon.textContent="favorite_border"
        fetch("removeLikeToPost.php?id="+encodeURIComponent(post.dataset.id)+"&user="+encodeURIComponent(profile.dataset.username)).then(onResponse).then(onJsonLike)
    }

}

function onJsonLike(json){
    const posts = document.querySelectorAll(".post")
    for(let i of posts){
        if(i.dataset.id == json.post_id){
            const like_button = i.querySelector(".lower_section").querySelector(".like")
            const num_likes = like_button.querySelector("p")
            num_likes.textContent = json.num_likes
        }
    }
}

function modifyPost(event){
    const overlay = document.querySelector("#modify_post")
    overlay.classList.remove("hidden")

    const title_sec = overlay.querySelector(".title_post")
    const comment_sec = overlay.querySelector(".comment_post")
    const post_id = overlay.querySelector("#post_id")

    const modify_button = event.currentTarget
    const post = modify_button.parentNode.parentNode.parentNode

    const title = post.querySelector(".upper_section").querySelector(".title").querySelector("h1")
    const comment = post.querySelector(".middle_section").querySelector("p")
    
    post_id.value = post.dataset.id
    title_sec.value = title.textContent
    comment_sec.value = comment.textContent

    
}

function onJsonComment(json){ 
    const posts = document.querySelectorAll(".post")
    for(let i of posts){
        if(i.dataset.id === json.post_id){
            const comment_section = i.querySelector(".comments_section")
            for(let comment of json.comments){
                const single_comment = document.createElement("div")
                single_comment.classList.add("single_comment")

                const comment_profile = document.createElement("div")
                comment_profile.classList.add("comment_profile")

                const p_profile = document.createElement("p")
                p_profile.textContent='@'+comment.user

                comment_profile.appendChild(p_profile)

                const comment_text = document.createElement("div")
                comment_text.classList.add("comment_text")
                comment_text.textContent=comment.comment

                single_comment.appendChild(comment_profile)
                single_comment.appendChild(comment_text)

                comment_section.appendChild(single_comment)
            }
            
        }
    }
}

