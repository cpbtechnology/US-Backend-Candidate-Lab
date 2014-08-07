//
//  FirstViewController.h
//  NoteViewer
//
//  Created by Evan Spielberg on 8/6/14.
//  Copyright (c) 2014 Evan Spielberg. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "LogInViewController.h"

@interface FirstViewController : UIViewController<LogInViewControllerDelegate>{
   
}
@property (nonatomic,retain) NSString * userNameString;
@property (nonatomic,retain) NSString * userIDString;
@property (nonatomic,retain) NSString * userPasswordString;


//Delegation Method(s)
-(void)logInViewControllerDidClickLogin: (LogInViewController *)controller userName:(NSString*)UN pass:(NSString*)PW;
@end
