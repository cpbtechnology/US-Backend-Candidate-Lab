//
//  LogInViewController.h
//  RecoveryLink
//
//  Created by Evan Spielberg on 3/11/14.
//  Copyright (c) 2014 Recovery Link. All rights reserved.
//

#import <UIKit/UIKit.h>

@class LogInViewController;//,KeychainItemWrapper;


@protocol LogInViewControllerDelegate <NSObject>
-(void)logInViewControllerDidClickLogin: (LogInViewController *)controller userName:(NSString*)UN pass:(NSString*)PW;

@end

@interface LogInViewController : UIViewController

@property (nonatomic, weak) id <LogInViewControllerDelegate> delegate;
- (IBAction)logIn:(id)sender;
@property (weak, nonatomic) IBOutlet UITextField *userNameTextField;
@property (weak, nonatomic) IBOutlet UITextField *passWordTextField;

@end


