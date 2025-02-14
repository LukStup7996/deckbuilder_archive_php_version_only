# deckbuilder_archive_php_version_only 

This project has been created as part of my portfolio and uses the MIT licsence. Any images and data used that are intellectual property of their respective authors/creators are not used for financial gains. This is a simple portfolio meant to show my personal skills, when it comes to working as a software developer. It is nice to look at and this version will not be hosted on any web browser. It can only be used locally and is meant as an hommage to my favourite part time activity.  

**What is this project all about?**
After 6 months of programming and working on a project all by myself I have decided to finally properly document this pet project of mine on GitHub. 
Intended as a part of my portfolio, I chose to create a SPA that combines one of my favourite hobbies, trading cards, with the skills I have acquired since the year 2022, during my studies at the Unviversity of Applied Scieneces Technikum Wien and beyond that. 
Now as the title suggest this is ONLY the backend version. The reasoning behind this is, that I am very pleased by how smoothly this particular version of my PHP backend looks and operates, BUT I have encountered a particular issue, that requires me to make significant changes, after six months.
And since I am very happy with this version, I chose to create a seperate repository to share and more importantly to highlight the differences between the pure backend version and the later integrated fullstack version.
The fullstack version will also contain this backend version, but in a slightly adjusted manor.

**So why PHP?**
When brainstorming on what kind of programming language I wanted to code in, I had a lot of choices. But there was one language I excelled at: PHP. 
Which posed even more choices, simple backend, WordPress or maybe a fullstack. And enthused as I am, I chose the latter. 
The reasons for those are rather simple, it suits me and it lets me share my understanding of an interface and all its integral parts. I have spent most of my time studying and practicing PHP, HTML, CSS and Javascript during my time at University, so it naturally became my choice of programming language when it comes down to creating a project. After all, that was a major part of my education, which I comparetively enjoyed a lot.

Additionally, as far as my understanding is concerned, it is one the more common programming languages that is used when communicating with a database. A lot of servers use PHP not only because of its simplicity, but also because of its rather good security. PHP cannot communicate with anything on its own. So in order to circumvent that, CORS was implemented. A rules violating script, that allows the communication of server environments to specific websites, on top of which, some of the more common server environments, like laravel or xampp, allready posses supporting scripts for php, making it more easily accessible for individuals, that wish to test my project.
I personally use xampp, since it is the server environment I am used to the most, but I want to make sure that you should be able to run this project from quite frankly any server environment, that has the proper PHP support.

**So how does it work?**
In genereal the deckbuilder_archive can be compared to any other online web page that has a searchbar/archive/browsing function, a shoppingbasket, as well as a receipt system and user created contents. In a sense it functions exactly the same as any other online shop, hotel or booking site, but it is packaged differently and provides trading card fans in particular with a fun experience in exploring my work.

**There are a lot of files, what for?**
Well since documentation, requirements engineering and project management, also made up a huge part of my studies, I am also somewhat versed in analyzing a projects need, planning that project and communicate its intricacies in a proper and understandable fashion. At least I hope that these additional files will help properly communicate what the project can do and should do, how it was created and so on. For the purpose of clearly understanding the project and as a part of my portfolio, I have created not only requirements documents, but also my own user stories, as well as a kanban board (GitHub is amazing, for having an integrated version) and different paper-prototypes. These (paper-prototypes) will be shared in the next repository though. 
In the hopes of keeping somewhat of an orderly manner, I will split the documentation between the backend and the frontend, especially since I need to alter my backend, so that I can focus on finalizing MS 7, in a manner that doesn't require configurations of specific server environments. I want this project to be easily accesible and setup for anyone who wants to try it out, so I need to find a solution that doesn't force users to run my pet project in a particular way.

**Why now and not six months ago?**
Well...I got a little carried away, to be frank. I wanted a clean documentation of my project, within a reasonable timeframe. 
Since my progress and my commits can be tracked very comfortably via GitHub, I wanted to make sure I actually got what it takes and that viewers of my project, can reasonably assess how long it would roughly take for me to setup a project and to work through it. And for that, I absolutely needed the practice. It is important to me, that I do not only posses a skill, but also hone it. One of my biggest concerns still is: Can I finish a project in an aggreed upon timeframe? And in order to do that, reprogramming just anything didn't quite cut it for me. I needed to make sure, that I can work through entire SDLC's on my own, as a part of me practicing. This is important to me, because I want to create the highest quality software possible. Now facing reality that is the right mindset, but I still have a long road to walk. After all it took me 6 months to get close to finishing a fullstack all on my own.
I made somewhat terrible decisions in my first requirements drafts and the structuring of my User Stories and I had to look up a lot of tricks and skills in order to produce an actual working program, that follows best practices in security, architecture and several other areas. 
My issues did not so much occur in actually producing code, but in making it work properly and as safely as I possibly can. The biggest stress factor was and still is User Access Control. No one should even be remotely endangered in using any future services I might be a part of. So I took my time and right now seems to be the perfect moment, to use GitHub to its fullest potential in a clean and professional manor.

**If you have been working on this project for six months allready, can we reasonably expect you to reprogramm your project without copy and pasting it here?**
Yes and no. For one I will be using my project as a template, which means if I encounter any grave mistakes I made while reprogramming my project from scratch, i will be using my allready existing files in order to correct these errors. But I will mainly programm these files from scratch.

**Are the timeframes set in your kanban board a little bit to short?**
That is a question I sadly cannot acurately answer just yet. Simply because I do not have enough experience to accurately assess that. But we will find out how fast I can reprogramm an allready functioning project. Think of it like programming your third online shop for your customers. At some point there will be slight differences between every interface, but at the core, their functions and logic largely stay the same.

**How do I install your project?**
First of all you will need to setup your own server environment. I personally suggest xampp, since it is easy to install and setup, but any server environment you are comfortable with (and that supports PHP) works. Then you can either create a new database named deckbuilder_archive and simply copy the contents of the deckbuilder_archive_xampp_MySQL_database_contents.pdf file into your SQL querry or import the included deckbuilder_archive.mysql file. 
If, you encounter issues with properly running the code, try creating the tables seperately instead and use the added ALTER TABLE commands to make sure all constraints work properly. Then you can INSERT all the data by copy and pasting the remaining command lines into your SQL querry box. Alternatively you will also find a database copy with v.0.0.6 as a part of the documentation.
Lastly just pull the entire project into your server environment folders (htdocs for xampp as an example) and alter the config.php file, so that it contains the neccessary baseURL and DB-Connection settings you are using.

**How do I use your deckbuilder_archive?**
Well  there are roughly four functions you can use:
1. You can browse the database archives with 'filterby' parameters. These are you used to filter cards based on their properties.
2. You can create your own user account and change your username and password, to your liking.
3. You can browse the database for allready existing decks (do keep in mind, that the database contents file, does not come with any users or decklists, you will need to create both of those by yourself first).
4. You can create your own decklist (much like a shopping cart) and post it to the database to make it accessible for other users (read-only). You can also alter that same list, whenever you like, as long as it is created by the currently logged in user.