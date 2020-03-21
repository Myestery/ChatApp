// console.log("Question 1");

// function findanagram(str1, str2) {
//     let str1arr = str1.split("");
//     let str2arr = str2.split("");
//     let answer = 0;
//     for (let x = 0; x < str1arr.length; x++) {
//         if (!str2arr.includes(str1arr[x])) {
//             if (x != 0) {
//                 str1arr.splice(x, x);
//                 answer++;
//             } else {
//                 str2arr.pop();
//                 answer++;
//             }
//         }
//     }

//     function next(arr, x) {
//         if (arr.length - 1 < arr.indexOf(x)) {
//             return arr[x + 1];
//         } else {
//             return arr[0];
//         }
//     }
//     for (let index = 0; index < str2.length; index++) {
//         if (next(str2arr, str2arr[index]) !== next(str1arr, str1arr[index])) {
//             if (index !== 0) {
//                 str1arr.splice(index, index);
//                 answer++;
//             } else {
//                 str2arr.pop();
//                 answer++;
//             }
//         }
//     }
//     return answer;
// }
// // console.log(findanagram('cffadb','ddfaacb'));
// // console.log(findanagram('abc','abc'));
// // console.log(findanagram('cab','abc'));

// console.log("question 3");

// function minimumswaps(size, integers) {
//     let answer = 0;
//     let sortedint = [];
//     integers = integers.split(" ");
//     for (let int of integers) {
//         sortedint.push(int);
//     }
//     sortedint.sort((a, b) => a - b);
//     for (let i = 0; i < sortedint.length; i++) {
//         if (integers[i] !== sortedint[i]) {
//             let temp = integers[i];
//             integers[i] = sortedint[i];
//             integers[sortedint.indexOf(temp)] = temp;
//             answer++;
//         }
//     }
//     return answer;
// }
// console.log(minimumswaps(5, "5 1 4 2 3"));
// // console.log(minimumswaps(8,'7 1 3 2 4 5 6 8'));
// // console.log(minimumswaps(9,'7 1 3 2 4 5 6 8 9'));

// console.log("Question 4");

// function specialstring(n, s) {
//     let answer = new Set();
//     s = s.split("");
//     let loopcount = new Array(s.length).fill(0).map((x, index) => index);
//     for (let one of loopcount) {
//         for (let x = 0; x < one; x++) {
//             let word = "";
//             for (let y = 0; y < s.length; y++) {
//                 word += s[y];
//                 answer.add(word);
//             }
//             answer.add(word);
//         }
//     }

//     function areallalike(arr) {
//         let test = arr.toString();
//         test = test.split("");
//         let ans = true;
//         for (let x = 0; x < test.length; x++) {
//             if (test[x] !== test[0]) {
//                 ans = false;
//             }
//         }
//         return ans;
//     }
//     answers = [...answer].sort();
//     answercopy = answers.join();
//     for (let x = 0; x < answers.length; x++) {
//         if (answers[x].length % 2 == 0 && !areallalike(answers[x])) {
//             answers.splice(x, x);
//         }
//         let middle = Math.ceil(answers[x].length / 2);
//         if (!areallalike(answers[x].split("").splice(middle, middle))) {
//             answers.splice(x, x);
//         }
//     }
//     for (let one of s) {
//         answers.push(one);
//     }
//     return answers.length;
// }
// //console.log(specialstring(8,'mummy'));
// console.log(specialstring(7, "mnonopo"));
// console.log(specialstring(9, "mnonopoor"));

// Binary search js
// function searchintarrayrecursively(array,x,left,right){
// if(left>right){
//     return false;
// }
// let mid= left +Math.ceil((right-left)/2);
// if(array[mid]==x){
//     return true;
// }else if(x<array[mid]){
//     return searchintarrayrecursively(array,x,left,mid-1);
// }else{
//     return searchintarrayrecursively(array,x,mid+1,right);
// }

// }
// function getallsubstrings(string){
//     string = string.split("");
//     let answer=new Set();
//         let loopcount = new Array(string.length).fill(0).map((x, index) => index);
//         for (let one of loopcount) {
//             for (let x = 0; x < one; x++) {
//                 let word = string[one];
//                 for (let y = 0; y < string.length; y++) {
//                     answer.add(word + string[y]);
//                 }
//                 answer.add(word);
//             }
// }
// return answer;
// }
// console.log([...getallsubstrings('musicismylife')]);
// function getAllSubstrings(string) {
//     let answer = new Set();
//     for (let index = 0; index < string.length; index++) {
//         for (let x = 0; x < string.length + 1; x++) {
//             answer.add(string.substring(index, x));
//         }
//     }
//     console.log([...answer]);
// }
// getAllSubstrings('victor');

// let array = new Array(10).fill(0).map((x, index) => x + index);
// console.log(array.reduce((acc,val)=>val>acc?val:acc));
// let a= prompt("input A, the coefficient of X-squared");
// let b= prompt("input B, the coefficient of X");
// let c= prompt("input C, the constant of the equation");
// let firstroot=(-b-Math.sqrt(b**2-4*a*c))/2*a;
// let secondroot=(-b+Math.sqrt(b**2-4*a*c))/2*a;
// console.log("The roots are "+firstroot+" and "+secondroot);
// let timeout = 30;
// let times = 0;
// let counter = 0;
// let array = Array(60)
//   .fill(0)
//   .map((x, index) => index + 1);
// for(let x=0;x<111;x++){
//     counter++;
//     if (counter >= Math.floor(timeout)) {
//         timeout = timeout / 2;
//         counter = 0;
//         if (array.length > 0) {
//         array.shift();
//         }
//       }
// }
// function analysis(x){
//   if(x==1){
//     return 3;
//   }else{
//     return 3+ (0.5*analysis(x-1));
//   }
// }
// console.log(analysis(4));
const story =
  "There was once an employee named Dwight. Dwigt was not very smart, but he was loyal. I could have promoted dwight but i did not";
const search = /Dwigh?t/gi;
const updatedstory = story.replace(search, "Samuel");
console.log(updatedstory);
const pets = [
  "cat: Smith,Meowsalot",
  "young dog: Jones, Barksalot",
  "rabbit: Doe, Fluffy"
];
const petpattern=/([a-z\s?]+):\s([a-z]+),([a-z ?]+)/i;
const petsUpdated=pets.map(pet=>pet.replace(petpattern,'$3 $2 <span class="description">$1</span>'));
petsUpdated.forEach(element => {
  $('#root').append(element+"<br>");
});

$(document).ready(function () {
  const usernamePattern=/^[a-z][a-z0-9]{7,29}$/i;
 $('#username').on('input',function(){
  if(usernamePattern.test(this.value)){
    $("#helpId").html("good username");
  }else{
    $("#helpId").html("Username must start with a letter, and must have up to 8 characters and less than 30 characters");
  }

  });
  const storyTwo = "There are a lot of phone numbers. One is 5555555555, and anothr is 123-123-1234.Yet another is 321.321.4321. Another is 555 555 5555. Did you know another phone number is 1 555 555 5555 and my friend has a number of (555) 123 1234. My other friend has a number of 555 555-5555 and another had 1.987.654.3210.";
  const phonePattern=/1?[-.\s]?\(?(\d{3})\)?[-.\s]?(\d{3})[-.\s]?(\d{4})/g;
  let results=storyTwo.match(phonePattern);
  if(!results) results=[];
  const resultsUniform = results.map(x => x.replace(phonePattern,'($1) $2-$3'));
  $('#root').html(`
  <hr>
  <p> There are ${results.length} phone numbers in this string of text
  <ul>
  ${resultsUniform.map(x =>`<li>${x}</li>`).join('')}
  </ul>
  `);
});
