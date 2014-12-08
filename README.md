simp
====

"simp" is a simple back-end service framework for PHP.
Based on command driven logic, It has a layered-structure and simple AOP concept.
You can easily use this framework for your simple ajax & mobile back-end service

## Version
0.1.0

## How it works
![simp architecture](https://cloud.githubusercontent.com/assets/5653885/5340518/cf70d86a-7f30-11e4-984c-8d19c5df253d.png)

## Example
See example files below sequentially,

|file|description|
|-----|-----|
| /html/user.html | test view|
| /manager/UserManager.php | for API service expose| 
| /core/aopconfig.json | for aop configuration|
| /model/UserInfo.php | for sample data model|

## AOP Concept

'simp' supports method-level AOP concept like below:
* before execute method
* after execute method
* before handle exception
* after handle exception

AOP configuration: You can setup AOP Execution by specifying target class and method. 'all' means default AOP config for the specified class.

```javascript
{
	"UserManager": 
	{
		"all": 
		{
			"before": 
			[
				{
					"class": "Logger",
					"method": "log"
				}
			],

			"after": 
			[
				{
					"class": "Logger",
					"method": "log"				
				}
			],

			"beforeError": 
			[
				{
					"class": "ErrorHandler",
					"method": "handleError"
										
				}
			],

			"afterError": 
			[
				{
					"class": "ErrorHandler",
					"method": "handleError"					
				}
			]
		}
	}
}
```

## Directories


| directory     |    description   |
|-------|------|
|aop| aop modules|
|core|base classes for framework|
|manager|service managers which is exposed as backend services|
|model|objects combined with data domain objact and data model|
|log|saved logs|
|html|html views|



##Todo's

 - Implement ClassLoader & Cache
 - Add Scope Feature (Server Instance, Session, Reqeust)
 - Add 'Schema(Table) to Model Auto-Generation' Feature
 - Add Front-End Javascript Auto-Generation Feature
 - Handling User Parameters In AOP Module

## License

MIT


**Free Software, Hell Yeah!**
