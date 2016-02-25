/* 
THIS CODE BELONGS TO AND IS UNDER FULL COPYRIGHT AND UN-DISTRIBUTING LICENSE OF 
A 100 WEB SOLUTIONS (http://www.a100websolutions.in). CODE MAY BE USED OR DISTRIBUTED 
UNDER SIMILAR AND UNCHANGED LICENSE AND FULL COPYRIGHT TO A 100 WEB SOLUTIONS
AND WITHOUT ANY CHANGES IN THE CORE CODING TECHNIQUES AND CONCEPT.
*/
$(document).ready(function(){
    var number1='',number2='',token,operator,flag=0,ans=0;
    $('.tokens').click(function(){
        token = $(this).text();
        if($(this).hasClass('numbers')){
            /* Check whether to append to second number or to first */
            if(flag === 0){
            number1 = number1 + token;
            }
            else{
            number2 = number2 + token;    
            }
        }
        else if($(this).hasClass('clear')){
            /* reset all values */
            number1 = '';number2 = '';operator='';token='';flag=0;
            /* reset display panel */
            $('.answer').text('');
        }
        else{
            /* tell the script that an operator has been encountered  
             * so staring of operand 2.
             * */
            if(number2 === '')
            {
            operator = token;
            flag = 1;
            }
            else{
            flag = 1;
            checkandcalc();
            number1 = ans;
            number2='';
            operator = token;
            }
        }
        
        /* Adding the string to the display panel */
        $('.answer').append(token);
    });
    
    $('.answerbutton').click(function(){
     checkandcalc();
     number1 = ans;
     number2='';
  });
    
    function checkandcalc(){
        /* Validation check for all inputs */ 
     if(number1 !== '' && number2 !== '' && operator !== ''){
        /* Calculate answer and display */
        var n1 = parseInt(number1);
        var n2 = parseInt(number2);
        
        /* function to calculate result */
        ans = calculate(n1,n2);
        
        /*  display answer on panel */
        $('.answer').text(ans);
        
      }
      else{
          alert('Give proper inputs');
        /* reset all values */
        number1 = '';number2 = '';operator='';token='';flag=0;  
        /* reset display panel */
            $('.answer').text('');
      }
    }
    
    function calculate(n1, n2){
        var ans = 0;
        switch(operator){
            case '+' :  ans = n1 + n2;
                        break;
            case '-' :  ans = n1 - n2;
                        break;
            case '*' :  ans = n1 * n2;
                        break;
            case '/' :  if(n2 !== 0){
                        ans = n1 / n2;
                        break;
                        }
                        else{
                            ans = 'Wrong input';
                        }
        }
        return ans;
    }
});

