//
//  FirstViewController.m
//  NoteViewer
//
//  Created by Evan Spielberg on 8/6/14.
//  Copyright (c) 2014 Evan Spielberg. All rights reserved.
//

#import "FirstViewController.h"
#import "LoginViewController.h"
#import "Reachability.h"
#import "MasterViewController.h"
#import "CreateNoteViewController.h"

@interface FirstViewController ()

@end

@implementation FirstViewController
@synthesize userNameString = _userNameString;
@synthesize userPasswordString = _userPasswordString;
@synthesize userIDString = _userIDString;
NSString *const rootServerURL = @"localhost:8888/US-Backend-Candidate-Lab/cakephp/";

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
    [self showLoginScreen];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([[segue identifier] isEqualToString:@"showTable"]) {
        MasterViewController *mVC = segue.destinationViewController;
        mVC.userNameString = _userNameString;
        mVC.userIDString = _userIDString;
        mVC.userPasswordString = _userPasswordString;
    }
    if ([[segue identifier] isEqualToString:@"showNewNote"]) {
        CreateNoteViewController *cNVC = segue.destinationViewController;
        cNVC.userNameString = _userNameString;
        cNVC.userIDString = _userIDString;
        cNVC.userPasswordString = _userPasswordString;
    }
}


-(void)showLoginScreen{
    UIStoryboard *storyboard = [UIStoryboard storyboardWithName:@"Main" bundle:nil];
    LogInViewController * lVC = (LogInViewController *)[storyboard instantiateViewControllerWithIdentifier:@"LogInViewController"];
    lVC.delegate = self;
    [self presentViewController:lVC animated:YES completion:Nil];
    
}
-(void)logInViewControllerDidClickLogin: (LogInViewController *)controller userName:(NSString*)UN pass:(NSString*)PW;
{
    NSLog(@"FirstViewController: DidClickLogin UN: %@ PW %@",UN,PW);
    
    //  [keychainItemWrapper setObject:[textControl text] forKey:editedFieldKey];
    if([UN length]!= 0){
        
        _userNameString = UN;
        _userPasswordString = PW;
       [self login];
        
    }
    else{
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Unable to Log In"
                                                        message:@"Please Enter a User Name"
                                                       delegate:nil
                                              cancelButtonTitle:@"OK"
                                              otherButtonTitles:nil];
        [alert show];
    }
    
    
    
}
-(void)login{
    
    BOOL credentialsCorrect = false;
    
    NSError* serverStringError = nil;
    //For a real project we'd change this to a more secure method
    NSString * loginStrWithCredentials = [[NSString alloc]initWithFormat:@"http://%@:%@@%@users/confirm.json",_userNameString,_userPasswordString,rootServerURL];
    //NSLog(@"loginStrWithCredentials = %@",loginStrWithCredentials);
    NSURL *urlServerJS= [[NSURL alloc] initWithString:loginStrWithCredentials];
    [UIApplication sharedApplication].networkActivityIndicatorVisible = YES;
    NSString *  serverJsonStr = [NSString stringWithContentsOfURL: urlServerJS encoding:NSUTF8StringEncoding error:&serverStringError];
    [UIApplication sharedApplication].networkActivityIndicatorVisible = NO;
    NSData* serverJsonData = [serverJsonStr dataUsingEncoding:NSUTF8StringEncoding];
    
    
    NSError* error;
    NSDictionary* json = [NSJSONSerialization
                          JSONObjectWithData:serverJsonData
                          options:kNilOptions
                          error:&error];
    NSLog(@"json = %@",json);
    
    NSDictionary* users = [json objectForKey:@"user"];
    
    NSLog(@"users: %@", users); //3
    if(error){
        NSLog(@"Error = %@",error);
    }
    if(error==NULL){
        
        NSDictionary *user = [users objectForKey:@"User"];
        NSLog(@"user = %@",user);
        
        NSString *userID = [user objectForKey:@"id"];
        _userIDString = userID;
        NSLog(@"userID = %@",userID);
        

        if(userID!=NULL){
        credentialsCorrect =true;
        }
    }
    
    
    
    if(credentialsCorrect){
    
    [self dismissViewControllerAnimated:YES completion:nil];
}

else{
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Unable to Log In"
                                                    message:@"Your credentials could not be validated"
                                                   delegate:nil
                                          cancelButtonTitle:@"OK"
                                          otherButtonTitles:nil];
    [alert show];
    
}


}
- (IBAction)unwindNew:(UIStoryboardSegue*) unwindSegue{
        
}

@end
