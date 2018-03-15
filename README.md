# twubric

## twubric = twitter + rubric

### What is rubric?
In a learning setting, a scoring rubric, typically, has a predefined set of weighted attributes mapped to a custom scale that together aid instructors to assess the quality of student submissions in an effective way.

For more information [Click Here](http://www.brighthubeducation.com/student-assessment-tools/18251-letter-grading-vs-rubrics/)

### Modeling a twubric
If you have an account on Twitter, you’d probably know that apart from normal people, there are:

1. bots
2. accounts that have zero activity. These were probably created by people unknowingly only for them to never come back and use it again.

While it is flattering to have these tweeps follow you, you’d want to weed them out at some point, I think (I would). So:

  + This is a web API that allows a Twitter user to review his followers, and their “scores” based on a rubric.

Criteria | Weightage | Scale
------------ | ------------- | -------------
Friends | 2 | High, Average, Low
Influence | 4 | High, Average, Low
Chirpy | 4 | High, Average, Low

Friends | Influence | Chirpy
------------ | ------------- | -------------
Low-0 to 999 | Low-0% to 35% | Low-0.0 to 0.5
Average-1K to 999999 | Average-36% to 70% | Average-0.5 to 1.0
High-1M< | High-71% to 100% | High-1.0<

## How to run the app?
To test this code you need to install dependencies with Composer, and run /twubric/index.php from your browser:

```shell
composer install

install php(version of php you are using)-curl
```
* For getting your API keys :-

  1. [Twitter](https://dev.twitter.com/apps/new)
  
  2. [Klout](https://klout.com/login)
 
### Use Cases

1. A web page (/twubric) from which you can login to the app using your Twitter account.

2. On logging in successfully, You are shown a list of your Twitter followers (/twubric/followers).

3. When you click on one follower you can see specific profile information about that follower (like the ones highlighted from the Twitter API response below).

```
{
 ...
 "followers_count": 110,
 "friends_count": 202,
 "listed_count": 10,
 ...
 "favourites_count": 55,
 "statuses_count": 1102
 ...
 "twubric": {
   "total": 6,        // user’s twubric score out of 10
   "friends": 1.5,        // user’s friend score out of 2
   "influence": 3,        // user’s influence score out of 4
   "chirpy": 2,        // user’s chirpiness score out of 4
  }
 ...
}

```
