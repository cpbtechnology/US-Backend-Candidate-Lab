//
//  LogInViewController.m
//  RecoveryLink
//
//  Created by Evan Spielberg on 3/11/14.
//  Copyright (c) 2014 Recovery Link. All rights reserved.
//

#import "LogInViewController.h"

@interface LogInViewController ()

@end

@implementation LogInViewController
@synthesize delegate;
@synthesize userNameTextField, passWordTextField;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    
    
    UIToolbar* userNameToolbar = [[UIToolbar alloc]initWithFrame:CGRectMake(0, 0, 320, 50)];
    userNameToolbar.barStyle = UIBarStyleBlackTranslucent;
    userNameToolbar.items = [NSArray arrayWithObjects:[[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:nil action:nil],
                           [[UIBarButtonItem alloc]initWithTitle:@"Done" style:UIBarButtonItemStyleDone target:self action:@selector(doneWithUserNameTextField)],
                           nil];
    [userNameToolbar sizeToFit];
    self.userNameTextField.inputAccessoryView = userNameToolbar;
    
    
    UIToolbar* passwordToolbar = [[UIToolbar alloc]initWithFrame:CGRectMake(0, 0, 320, 50)];
    passwordToolbar.barStyle = UIBarStyleBlackTranslucent;
    passwordToolbar.items = [NSArray arrayWithObjects:[[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:nil action:nil],
                             [[UIBarButtonItem alloc]initWithTitle:@"Done" style:UIBarButtonItemStyleDone target:self action:@selector(doneWithPasswordTextField)],
                             nil];
    [passwordToolbar sizeToFit];
    self.passWordTextField.inputAccessoryView = passwordToolbar;

    

    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/
- (IBAction)logIn:(id)sender{
    NSLog(@"LogInViewController: Clicked Login");
    [self.delegate logInViewControllerDidClickLogin:self userName:self.userNameTextField.text pass:self.passWordTextField.text];
}

- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self.userNameTextField resignFirstResponder];
        [self.passWordTextField resignFirstResponder];
    
    
}


-(void)cancelNumberPad{
    [self.userNameTextField resignFirstResponder];
    self.userNameTextField.text = @"";
}

-(void)doneWithUserNameTextField{
  //  NSString *textFromTheKeyboard = self.userNameTextField.text;
  //  NSLog(@"Weight = %@",textFromTheKeyboard);
    [self.userNameTextField resignFirstResponder];
}


-(void)doneWithPasswordTextField{
    //  NSString *textFromTheKeyboard = self.userNameTextField.text;
    //  NSLog(@"Weight = %@",textFromTheKeyboard);
    [self.passWordTextField resignFirstResponder];
}






@end
